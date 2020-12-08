<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('suggestedBy'),
            AssociationField::new('previousQuestion'),
            AssociationField::new('nextQuestion'),
            AssociationField::new('difficulty'),
            TextField::new('label'),
            TextField::new('codeImage'),
            TextareaField::new('answerExplanations'),
            TextField::new('liveSnippetUrl'),
            TextField::new('twitterPollUrl'),
            TextareaField::new('differencesOutputNotes'),
            DateTimeField::new('createdAt'),
        ];
    }
}
