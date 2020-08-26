<?php declare(strict_types=1);

namespace App\Data;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionData
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
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
}
