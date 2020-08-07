<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Twig\ApiExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @see QuestionControllerTest
 */
class QuestionController extends AbstractController
{
    private QuestionRepository $questionRepository;
    private ApiExtension $apiExtension;

    public function __construct(QuestionRepository $questionRepository, ApiExtension $apiExtension)
    {
        $this->questionRepository = $questionRepository;
        $this->apiExtension = $apiExtension;
    }

    /**
     * @Route("/question/{id}", name="show", requirements={"id"="\d+"})
     * @Route("/question/{id}.json", name="show_json", defaults={"_format": "json"})
     */
    public function show(int $id, string $_route): Response
    {
        $question = $this->questionRepository->find($id);
        if (!$question instanceof Question) {
            throw $this->createNotFoundException('Question not found!');
        }

        if ($_route === 'show_json') {
            return new JsonResponse($this->apiExtension->serialize($question, 'show'), Response::HTTP_OK, [], true);
        }

        return $this->render('answer/show.html.twig', [
            'question' => $question,
            'count' => $this->questionRepository->count([])
        ]);
    }
}
