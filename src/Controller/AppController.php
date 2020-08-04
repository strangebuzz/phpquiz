<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @see AppControllerTest
 */
class AppController extends AbstractController
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('app/home.html.twig', ['count' => $this->questionRepository->count([])]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('app/about.html.twig');
    }
}
