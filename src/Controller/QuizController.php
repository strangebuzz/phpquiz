<?php declare(strict_types=1);

namespace App\Controller;

use App\Data\QuizData;
use App\Form\QuizType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quiz", name="quiz_")
 */
class QuizController extends AbstractController
{
    private QuizData $quizData;

    public function __construct(QuizData $quizData)
    {
        $this->quizData = $quizData;
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
     * @Route("/{uuid}", name="question", requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     * @see https://stackoverflow.com/q/136505/633864
     */
    public function question(Request $request, string $uuid, string $_route): Response
    {
        $quiz = $this->quizData->getQuiz($uuid);
        try {
            $quizQuestion = $this->quizData->getQuizQuestion($quiz);
        } catch (\Exception $e) {
            return $this->redirectToRoute('quiz_result', ['uuid' => $uuid]);
        }

        $form = $this->createForm(QuizType::class, [], [
            'quiz_question' => $quizQuestion,
            'action' => $this->generateUrl($_route, ['uuid' => $uuid]),
        ])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizQuestion->setAnswer($form->getData()['answer']);
            $this->get('doctrine')->getManager()->flush();

            return $this->redirectToRoute($_route, ['uuid' => $uuid]);
        }

        return $this->render('quiz/show.html.twig', $this->quizData->getViewParameters($quizQuestion, $form));
    }

    /**
     * @Route("/{uuid}/result", name="result", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     */
    public function result(string $uuid): Response
    {
        $quiz = $this->quizData->getQuiz($uuid);
        $parameters['quiz'] = $quiz;

        // All questons answered?
        try {
            $parameters['score'] = $quiz->getScore();
        } catch (\Exception $e) {

            return $this->redirectToRoute('quiz_question', ['uuid' => $uuid]);
        }

        $parameters['count'] = count($quiz->getQuestions());

        return $this->render('quiz/result.html.twig', $parameters);
    }
}
