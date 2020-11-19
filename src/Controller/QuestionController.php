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
        return $this->renderQuestion($this->questionData->getQuestion($id));
    }

    /**
     * @Route("/random", name="random")
     */
    public function random(): Response
    {
        return $this->renderQuestion($this->questionData->getRandomQuestion());
    }

    /**
     * @Route("/last", name="last")
     */
    public function last(): Response
    {
        return $this->renderQuestion($this->questionData->getLastQuestion());
    }

    private function renderQuestion(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
            'code' => $this->questionData->getSourceCode($question),
            'count' => $this->questionData->count(),
        ]);
    }
}
