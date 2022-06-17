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
    public function __construct(
        private QuestionRepository $questionRepository,
        private AnswerRepository $answerRepository,
        private string $sourceCodeDirectory
    ) {
    }

    public function getQuestion(int $id): Question
    {
        $question = $this->questionRepository->findOneWithNav($id);
        if (!$question instanceof Question) {
            throw new NotFoundHttpException('Question not found!');
        }

        return $question;
    }

    public function count(): int
    {
        return $this->questionRepository->count([]);
    }

    public function getRandomQuestion(): Question
    {
        $offset = mt_rand(0, $this->count() - 1);
        $questions = $this->questionRepository->findBy([], null, 1, $offset);
        if (\count($questions) > 0) {
            return $questions[0];
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
        $stats = $this->answerRepository->calculateCorrectAnswerStatistics();
        foreach ($stats as ['code' => $code, 'count' => $count]) {
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
