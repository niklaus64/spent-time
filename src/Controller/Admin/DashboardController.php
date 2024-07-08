<?php

namespace App\Controller\Admin;

// use ClientCrudController;
use App\Entity\Project;
use App\Entity\Client;
use App\Entity\Member;
use App\Entity\TimeEntry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/admin-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Spent time');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Client', 'fas fa-list', Client::class);
        yield MenuItem::linkToCrud('Project', 'fas fa-list', Project::class);
        yield MenuItem::linkToCrud('Member', 'fas fa-list', Member::class);
        yield MenuItem::linkToCrud('TimeEntry', 'fas fa-list', TimeEntry::class);
    }
}
