<?php

namespace App\Controller\Admin;

use App\Entity\TimeEntry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TimeEntryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TimeEntry::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('externalId', 'ID zewnętrzne'),
            AssociationField::new('project', 'Projekt'),
            AssociationField::new('member', 'Członek'),
            DateTimeField::new('startTime', 'Czas rozpoczęcia'),
            DateTimeField::new('endTime', 'Czas zakończenia'),
            TextField::new('description', 'Opis'),
        ];
    }
}
