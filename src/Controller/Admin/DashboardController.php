<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Link;
use App\Entity\Person;
use App\Entity\Question;
use App\Entity\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerer")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(QuizCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('PHPQuiz 🐘');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('APi Platform', 'fas fa-spider', '/api');
        yield MenuItem::subMenu('Docker', 'fas fa-server')->setSubItems([
            MenuItem::linkToUrl('Adminer', 'fas fa-database', 'http://127.0.0.1:8986')->setLinkRel('noreferrer'),
        ]);
        yield MenuItem::subMenu('Entities', 'fas fa-database')->setSubItems([
            MenuItem::linkToCrud('Quiz', 'fas fa-check-circle', Quiz::class),
            MenuItem::linkToCrud('Answer', 'fas fa-list', Answer::class),
            MenuItem::linkToCrud('Link', 'fas fa-link', Link::class),
            MenuItem::linkToCrud('Person', 'fas fa-user', Person::class),
            MenuItem::linkToCrud('Question', 'fas fa-question', Question::class),
        ]);
        yield MenuItem::linktoRoute('Answers stats', 'fas fa-chart-bar', 'admin_stats');
        yield MenuItem::linkToUrl('Front website', 'fas fa-external-link-alt', '/');
    }
}
