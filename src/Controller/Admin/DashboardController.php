<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Link;
use App\Entity\Person;
use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EasyAdmin dashboard.
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/gerer")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(AnswerCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('PHPQuiz 🐘');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::subMenu('Docker', 'fas fa-server')->setSubItems([
            MenuItem::linkToUrl('Adminer', 'fas fa-database', 'http://127.0.0.1:8986')->setLinkRel('noreferrer'),
        ]);
        yield MenuItem::linkToCrud('Answer', 'fas fa-list', Answer::class);
        yield MenuItem::linkToCrud('Link', 'fas fa-link', Link::class);
        yield MenuItem::linkToCrud('Person', 'fas fa-user', Person::class);
        yield MenuItem::linkToCrud('Question', 'fas fa-question', Question::class);
        yield MenuItem::linktoRoute('Front website', 'fas fa-external-link-alt', 'home');
    }
}
