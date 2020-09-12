<?php declare(strict_types=1);

namespace App\Controller;

use App\Data\QuestionData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quiz", name="quiz_")
 */
class QuizController extends AbstractController
{
    private QuestionData $questionData;

    public function __construct(QuestionData $questionData)
    {
        $this->questionData = $questionData;
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
        dump($uuid);

        // 1. Get all questions available and randomize
        $questions = $this->questionData->getQuestions();
        dump($questions); die();

        // 2. Create a new quiz with all the questions

        //  quiz
        // id
        // uuid
        // created_at
        // current question

        // quiz / questions

        //  quiz / answer
        // quiz_id
        // question_id
        // answer_code
        // created_at

        // Addflash your quiz has been created, you access to it later with this URL.

        return $this->redirectToRoute('quiz_show', ['uuid' => $uuid]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     * @see https://stackoverflow.com/q/136505/633864
     */
    public function show(int $uuid): Response
    {
        dump($uuid); die();
    }
}
