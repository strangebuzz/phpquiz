<?php declare(strict_types=1);

namespace App\Controller;

use App\Data\QuestionData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @see AppControllerTest
 */
class AppController extends AbstractController
{
    private QuestionData $questionData;

    public function __construct(QuestionData $questionData)
    {
        $this->questionData = $questionData;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('app/home.html.twig', [
            'count' => $this->questionData->count(),
            'last' => $this->questionData->getLastQuestion(),
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('app/about.html.twig');
    }
}
