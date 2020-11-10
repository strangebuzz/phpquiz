<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerer/quiz")
 */
class QuizCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quiz::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('id'),
            TextField::new('uuid'),
            TextField::new('adminScore'),
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $accessQuizAction = Action::new('accessQuiz', 'Access Quiz', 'fa fa-external-link')
            ->linkToRoute('admin_quiz_access', fn (Quiz $entity) => ['uuid' => $entity->getUuid()]);

        return $actions->add(Crud::PAGE_INDEX, $accessQuizAction);
    }

    /**
     * @Route("/{uuid}/access", name="admin_quiz_access", requirements={"uuid"="%requirements.uuid%"})
     */
    public function access(string $uuid): Response
    {
        return $this->redirectToRoute('quiz_question', compact('uuid'));
    }
}
