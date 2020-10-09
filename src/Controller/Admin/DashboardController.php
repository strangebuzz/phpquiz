<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Data\QuestionData;
use App\Entity\Answer;
use App\Entity\Link;
use App\Entity\Person;
use App\Entity\Question;
use App\Entity\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EasyAdmin dashboard.
 *
 * @Route("/gerer")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/")
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
        yield MenuItem::linkToCrud('Quiz', 'fas fa-check-circle', Quiz::class);
        yield MenuItem::linkToCrud('Answer', 'fas fa-list', Answer::class);
        yield MenuItem::linkToCrud('Link', 'fas fa-link', Link::class);
        yield MenuItem::linkToCrud('Person', 'fas fa-user', Person::class);
        yield MenuItem::linkToCrud('Question', 'fas fa-question', Question::class);
        yield MenuItem::linktoRoute('Answers stats', 'fas fa-chart-bar', 'admin_stats');
        yield MenuItem::linktoRoute('Front website', 'fas fa-external-link-alt', 'home');
    }

    /**
     * @Route("/stats", name="admin_stats")
     */
    public function stats(QuestionData $questionData): Response
    {
        return $this->render('admin/stats.html.twig', $questionData->getAnswersStats());
    }
}
