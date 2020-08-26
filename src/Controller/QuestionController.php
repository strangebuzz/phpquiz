<?php declare(strict_types=1);

namespace App\Controller;

use App\Data\QuestionData;
use App\Twig\SourceExtension;
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
    private SourceExtension $sourceExtension;

    public function __construct(QuestionData $questionData, SourceExtension $sourceExtension)
    {
        $this->questionData = $questionData;
        $this->sourceExtension = $sourceExtension;
    }

    /**
     * @Route("/{id}", name="show", requirements={"id"="\d+"})
     * @Route("/{id}.json", name="show_json", defaults={"_format": "json"})
     */
    public function show(int $id, string $_route): Response
    {
        $question = $this->questionData->getQuestion($id);
        if ($_route === 'question_show_json') {
            return $this->json($question, Response::HTTP_OK, [], ['groups' => 'show']);
        }

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'code' => $this->sourceExtension->getSource($question),
            'count' => $this->questionData->count()
        ]);
    }

    /**
     * @Route("/random", name="random")
     */
    public function random(): Response
    {
        $question = $this->questionData->getRandomQuestion();

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'code' => $this->sourceExtension->getSource($question),
            'count' => $this->questionData->count()
        ]);
    }
}
