<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Data\QuestionData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerer")
 */
class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="admin_stats")
     */
    public function stats(QuestionData $questionData): Response
    {
        return $this->render('admin/stats.html.twig', ['data' => $questionData->getAnswersStatistics()]);
    }
}
