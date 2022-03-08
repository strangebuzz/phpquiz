<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\QuizData;
use App\Form\QuizType;
use App\Repository\QuizQuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quiz", name="quiz_")
 */
class QuizController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private QuizData $quizData,
        private QuizQuestionRepository $quizQuestionRepository
        ) {
    }

    /**
     * Create a new recorded quiz.
     *
     * @Route("/new", name="new")
     */
    public function new(): Response
    {
        return $this->redirectToRoute('quiz_question', ['uuid' => $this->quizData->generateQuiz()->getUuid()]);
    }

    /**
     * @Route("/{uuid}", name="question", requirements={"uuid"="%requirements.uuid%"})
     *
     * @see https://stackoverflow.com/q/136505/633864
     */
    public function question(Request $request, string $uuid, string $_route): Response
    {
        $quiz = $this->quizData->getQuiz($uuid);

        try {
            $quizQuestion = $this->quizData->getQuizQuestion($quiz);
        } catch (\Exception) {
            return $this->redirectToRoute('quiz_result', ['uuid' => $uuid]);
        }

        $form = $this->createForm(QuizType::class, [], [
            'quiz_question' => $quizQuestion,
            'action' => $this->generateUrl($_route, ['uuid' => $uuid]),
        ])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizQuestion->setAnswer($form->getData()['answer']);
            $this->entityManager->flush();

            return $this->redirectToRoute($_route, ['uuid' => $uuid]);
        }

        return $this->render('quiz/show.html.twig', $this->quizData->getViewParameters($quizQuestion, $form));
    }

    /**
     * @Route("/{uuid}/result", name="result", methods={"GET"}, requirements={"uuid"="%requirements.uuid%"})
     */
    public function result(string $uuid): Response
    {
        $quiz = $this->quizData->getQuiz($uuid);
        // Can't get the score if not all questons were answered.
        try {
            $parameters['score'] = $quiz->getScore();
        } catch (\Exception) {
            return $this->redirectToRoute('quiz_question', ['uuid' => $uuid]);
        }

        $parameters['quiz'] = $quiz;
        $parameters['questions'] = $this->quizQuestionRepository->getQuestionsByRank($quiz);
        $parameters['count'] = count($parameters['questions']);

        return $this->render('quiz/result.html.twig', $parameters);
    }

    /**
     * @Route("/{uuid}/retry", name="retry", methods={"GET"}, requirements={"uuid"="%requirements.uuid%"})
     */
    public function retry(string $uuid): Response
    {
        $this->quizData->getQuiz($uuid)->reset();
        $this->entityManager->flush();

        return $this->redirectToRoute('quiz_question', ['uuid' => $uuid]);
    }
}
