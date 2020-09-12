<?php declare(strict_types=1);

namespace App\Controller;

use App\Data\QuestionData;
use App\Data\QuizData;
use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quiz", name="quiz_")
 */
class QuizController extends AbstractController
{
    private QuestionData $questionData;
    private QuizData $quizData;

    public function __construct(QuestionData $questionData, QuizData $quizData)
    {
        $this->questionData = $questionData;
        $this->quizData = $quizData;
    }

    /**
     * Create a new recorded quiz.
     *
     * @Route("/new", name="new")
     */
    public function create(): Response
    {
        // 1. get a new uid that will be the identifier of the quiz
        $uuid = uuid_create();

        // 2. Get all questions available
        $questions = $this->questionData->getQuestions();

        // 2. Create a new quiz with all the questions
        $quiz = new Quiz();
        $quiz->setUuid($uuid);
        $em = $this->getDoctrine()->getManager();

        foreach ($questions as $question) {
            $quizQuestion = new QuizQuestion();
            $quizQuestion->setQuiz($quiz);
            $quizQuestion->setQuestion($question);
            $em->persist($quizQuestion);
        }

        $em->persist($quiz);
        $em->flush();

        return $this->redirectToRoute('quiz_show', ['uuid' => $uuid]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     * @see https://stackoverflow.com/q/136505/633864
     */
    public function show(string $uuid): Response
    {
        $question = $this->quizData->getQuiz($uuid)->getQuestion();
        if ($question === null) {
            return $this->redirectToRoute('quiz_result', ['uuid' => $uuid]);
        }

        return $this->render('quiz/show.html.twig', $this->questionData->getViewParameters($question));
    }

    /**
     * @todo
     *
     * @Route("/{uuid}", name="answer", methods={"POST"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     */
    public function answer(Request $request, string $uuid): Response
    {
        $quiz = $this->quizData->getQuiz($uuid);
        dump($quiz); die();
    }

    /**
     * @todo
     *
     * @Route("/result/{uuid}", name="result", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     */
    public function result(Request $request, string $uuid): Response
    {
        $quiz = $this->quizData->getQuiz($uuid);
        dump($quiz); die();
    }
}
