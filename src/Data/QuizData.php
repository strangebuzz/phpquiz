<?php declare(strict_types=1);

namespace App\Data;

use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Repository\QuizRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuizData
{
    private QuizRepository $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    public function getQuiz(string $uuid): Quiz
    {
        $quiz = $this->quizRepository->findOneByUuid($uuid);
        if (!$quiz instanceof Quiz) {
            throw new NotFoundHttpException('Quiz not found!');
        }

        return $quiz;
    }

    /**
     * @return array<string,mixed>
     */
    public function getViewParameters(QuizQuestion $quizQuestion, FormInterface $form): array
    {
        return [
            'question' => $quizQuestion->getQuestion(),
            'count' => count($quizQuestion->getQuestion()->getAnswers()),
            'form' => $form->createView(),
        ];
    }
}
