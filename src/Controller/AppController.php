<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\QuestionData;
use App\Form\QuizRestoreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function home(Request $request): Response
    {
        $form = $this->createForm(QuizRestoreType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('quiz_question', ['uuid' => $form->getData()['uuid']]);
        }

        return $this->render('app/home.html.twig', [
            'count' => $this->questionData->count(),
            'last'  => $this->questionData->getLastQuestion(),
            'form'  => $form->createView()
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
