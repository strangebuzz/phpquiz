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
    public function __construct(
        private QuestionData $questionData
    ) {
    }

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request): Response
    {
        $form = $this->createForm(QuizRestoreType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var array{uuid: string} $formData */
            $formData = $form->getData();

            return $this->redirectToRoute('quiz_question', ['uuid' => $formData['uuid']]);
        }

        return $this->render('app/home.html.twig', [
            'count' => $this->questionData->count(),
            'last' => $this->questionData->getLastQuestion(),
            'form' => $form->createView(),
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
