<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('externalId', 'ID zewnętrzne'),
            TextField::new('name', 'Nazwa'),
            BooleanField::new('billable', 'Opłacalny'),
            AssociationField::new('client', 'Klient'),
            CollectionField::new('timeEntries', 'Zapisy czasowe')->hideOnForm(),
        ];
    }

}
