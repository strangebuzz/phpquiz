<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Person;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PersonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Person::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('twitter'),
            TextField::new('pseudo'),
        ];
    }
}
