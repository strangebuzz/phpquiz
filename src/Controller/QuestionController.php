<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\QuestionData;
use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question", name="question_")
 *
 * @see QuestionControllerTest
 */
class QuestionController extends AbstractController
{
    private QuestionData $questionData;

    public function __construct(QuestionData $questionData)
    {
        $this->questionData = $questionData;
    }

    /**
     * @Route("/{id}", name="show", requirements={"id"="\d+"}, defaults={"id": 1})
     */
    public function show(int $id): Response
    {
        return $this->renderQuestion($this->questionData->getQuestion($id), $id);
    }

    /**
     * @Route("/random", name="random")
     */
    public function random(): Response
    {
        [$position, $question] = $this->questionData->getRandomQuestion();
        return $this->renderQuestion($question, $position);
    }

    /**
     * @Route("/last", name="last")
     */
    public function last(): Response
    {
        return $this->renderQuestion($this->questionData->getLastQuestion(), $this->questionData->count());
    }

    private function renderQuestion(Question $question, int $position): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
            'position' => $position,
            'count' => $this->questionData->count(),
        ]);
    }
}
