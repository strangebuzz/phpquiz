<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @see QuestionControllerTest
 */
class QuestionController extends AbstractController
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @Route("/question/{id}", name="show", requirements={"id"="\d+"})
     */
    public function show(int $id): Response
    {
        $question = $this->questionRepository->find($id);
        if (!$question instanceof Question) {
            throw $this->createNotFoundException('Question not found!');
        }

        return $this->render('answer/show.html.twig', [
            'question' => $question,
        ]);
    }
}
