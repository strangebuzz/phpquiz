<?php declare(strict_types=1);

namespace App\Data;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Repository\QuizQuestionRepository;
use App\Repository\QuizRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuizData
{
    private QuizRepository $quizRepository;
    private QuizQuestionRepository $quizQuestionRepository;

    public function __construct(QuizRepository $quizRepository, QuizQuestionRepository  $quizQuestionRepository)
    {
        $this->quizRepository = $quizRepository;
        $this->quizQuestionRepository = $quizQuestionRepository;
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
        $quiz = $quizQuestion->getQuiz();
        $questions = [];
        if ($quiz instanceof Quiz) {
            $questions = $quiz->getQuestions();
        }

        return [
            'quiz_question' => $quizQuestion,
            'question' => $quizQuestion->getQuestion(),
            'count' => count($questions),
            'form' => $form->createView(),
        ];
    }

    /**
     * Get the current quiz-question to answer.
     */
    public function getQuizQuestion(Quiz $quiz): QuizQuestion
    {
        foreach ($this->quizQuestionRepository->getQuestionsByRank($quiz) as $quizQuestion) {
            if ($quizQuestion->getAnswer() === null) {
                return $quizQuestion;
            }
        }

        throw new \LogicException('All questions of this quiz already answered.');
    }
}
