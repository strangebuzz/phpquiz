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
        if ($id === 1) {
            $limit = 2; // Get 2 questions: current and next
            $offset = 0;
            $minResultCount = 1; // At least, one result
            $currentPosition = 0; // Current question will be at position "0"
        } else {
            $limit = 3; // Get 3 questions : previous, current and next
            $offset = $id - 2;
            $minResultCount = 2; // At least, two results
            $currentPosition = 0; // Current question will be at position "1"
        }
        $questions = $this->questionRepository->findBy([], ['createdAt' => 'ASC'], $limit, $offset);

        $resultCount = \count($questions);

        if ($resultCount < $minResultCount) {
            throw new NotFoundHttpException("Question {$id} not found!");
        }

        $question = $questions[$currentPosition];
        if ($currentPosition > 0) {
            $question->previousQuestion = $questions[$currentPosition - 1];
        }
        if (isset($questions[$currentPosition + 1])) {
            $question->nextQuestion = $questions[$currentPosition + 1];
        }

        return $question;
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
