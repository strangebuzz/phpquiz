<?php

declare(strict_types=1);

namespace App\Data;

use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class QuestionData
{
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;
    private string $sourceCodeDirectory;

    public function __construct(
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository,
        string $sourceCodeDirectory
    ) {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->sourceCodeDirectory = $sourceCodeDirectory;
    }

    public function getQuestion(int $id): Question
    {
        $questions = $this->questionRepository->findBy(['id' => $id], [], 1);

        $resultCount = \count($questions);

        if (\count($questions) === 0) {
            throw new NotFoundHttpException("Question {$id} not found!");
        }

        return $questions[0];
    }

    public function count(): int
    {
        return $this->questionRepository->count([]);
    }

    public function getRandomQuestion(): array
    {
        $offset = \mt_rand(0, $this->count() - 1);
        $questions = $this->questionRepository->findBy([], null, 1, $offset);
        if (\count($questions) > 0) {
            return [$offset, $questions[0]];
        }
        throw new HttpException(500, 'Could not return random question for offset '.$offset);
    }

    public function getLastQuestion(): Question
    {
        $questions = $this->questionRepository->findBy([], ['createdAt' => 'DESC'], 1, 0);
        if (\count($questions) > 0) {
            return $questions[0];
        }
        throw new HttpException(500, 'Could not return the last question');
    }

    public function getAnswersStatistics(): AnswerStatistics
    {
        $answerStatistics = new AnswerStatistics();

        foreach ($this->answerRepository->calculateCorrectAnswerStatistics() as ['code' => $code, 'count' => $count]) {
            $answerStatistics->answerCodes[$code] = $count;
            $answerStatistics->sum += $count;
        }

        return $answerStatistics;
    }

    public function getSourceCode(Question $question): string
    {
        $filename = sprintf($this->sourceCodeDirectory.'/%d.php', $question->getId());
        if (!is_file($filename)) {
            throw new \InvalidArgumentException(sprintf('Question code not found, create the "/code/%d.php" file.', $question->getId()));
        }

        return (string) file_get_contents($filename);
    }
}
