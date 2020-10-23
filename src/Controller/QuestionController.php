<?php declare(strict_types=1);

namespace App\Controller;

use App\Data\QuestionData;
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
        $question = $this->questionData->getQuestion($id);

        return $this->render('question/show.html.twig', $this->questionData->getViewParameters($question));
    }

    /**
     * @Route("/random", name="random")
     */
    public function random(): Response
    {
        $question = $this->questionData->getRandomQuestion();

        return $this->render('question/show.html.twig', $this->questionData->getViewParameters($question));
    }

    /**
     * @Route("/last", name="last")
     */
    public function last(): Response
    {
        $question = $this->questionData->getLastQuestion();

        return $this->render('question/show.html.twig', $this->questionData->getViewParameters($question));
    }
}
