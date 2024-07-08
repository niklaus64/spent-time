<?php

namespace App\Command;

use App\Entity\Member;

use App\Service\ClockifyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchClockifyDataCommand extends Command
{
    protected static $defaultName = 'app:fetch-clockify-data';
    private $clockifyService;

    public function __construct(ClockifyService $clockifyService, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->clockifyService = $clockifyService;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetches data from Clockify and syncs with the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workspaceId = $this->clockifyService->getWorkspaceId();

        $clientsData = $this->clockifyService->fetchData("workspaces/{$workspaceId}/clients");
        $this->clockifyService->syncClients($clientsData);

        $projectsData = $this->clockifyService->fetchData("workspaces/{$workspaceId}/projects");
        $this->clockifyService->syncProjects($projectsData);

        $membersData = $this->clockifyService->fetchData("workspaces/{$workspaceId}/users");
        $this->clockifyService->syncMembers($membersData);

        
        $externalMembers = $this->entityManager->getRepository(Member::class)
        ->getAllExternalUsers();
        foreach ($externalMembers as $externalMember) {
            $timeEntriesData = $this->clockifyService->fetchData("workspaces/{$workspaceId}/user/{$externalMember->getExternalId()}/time-entries");
            $this->clockifyService->syncTimeEntries($timeEntriesData);
        }

        return Command::SUCCESS;
    }
}
