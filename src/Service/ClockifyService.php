<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Member;
use App\Entity\TimeEntry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClockifyService
{
    private $apiKey;
    private $workspaceId;

    public function __construct(private readonly HttpClientInterface $http, private readonly EntityManagerInterface $entityManager)
    {
        $this->apiKey = $_ENV['CLOCKIFY_API_KEY'] ?? null;
        $this->workspaceId = $_ENV['CLOCKIFY_WORKSPACE_ID'] ?? null;
    }

    public function getWorkspaceId(): ?string
    {
        return $this->workspaceId;
    }

    public function fetchData(string $endpoint): array
    {
        $response = $this->http->request('GET', 'https://api.clockify.me/api/v1/' . $endpoint, [
            'headers' => [
                'X-Api-Key' => $this->apiKey,
            ],
        ]);

        return $response->toArray();
    }

    public function syncClients(array $clientsData)
    {
        foreach ($clientsData as $clientData) {
            $client = $this->entityManager->getRepository(Client::class)
                ->findOneBy(['externalID' => $clientData['id']]);

            if (!$client) {
                $client = new Client();
                $client->setExternalID($clientData['id']);
            }

            $client->setName($clientData['name']);
            $this->entityManager->persist($client);
        }

        $this->entityManager->flush();
    }

    public function syncProjects(array $projectsData)
    {
        foreach ($projectsData as $projectData) {
            $project = $this->entityManager->getRepository(Project::class)
                ->findOneBy(['externalID' => $projectData['id']]);

            if (!$project) {
                $project = new Project();
                $project->setExternalID($projectData['id']);
            }

            $project->setName($projectData['name']);
            $project->setBillable($projectData['billable']);
            $client = $this->entityManager->getRepository(Client::class)
                ->findOneBy(['externalID' => $projectData['clientId']]);
            $project->setClient($client);

            $this->entityManager->persist($project);
        }

        $this->entityManager->flush();
    }

    public function syncMembers(array $membersData)
    {
        foreach ($membersData as $memberData) {
            $member = $this->entityManager->getRepository(Member::class)
                ->findOneBy(['externalID' => $memberData['id']]);

            if (!$member) {
                $member = new Member();
                $member->setExternalID($memberData['id']);
            }

            $member->setName($memberData['name']);
            $member->setEmail($memberData['email']);

            $this->entityManager->persist($member);
        }

        $this->entityManager->flush();
    }

    public function syncTimeEntries(array $timeEntriesData)
    {
        foreach ($timeEntriesData as $timeEntryData) {
            $timeEntry = $this->entityManager->getRepository(TimeEntry::class)
                ->findOneBy(['externalID' => $timeEntryData['id']]);

            if (!$timeEntry) {
                $timeEntry = new TimeEntry();
                $timeEntry->setExternalID($timeEntryData['id']);
            }

            $timeEntry->setDescription($timeEntryData['description']);
            $timeEntry->setStartTime(new \DateTime($timeEntryData['timeInterval']['start']));
            $timeEntry->setEndTime(new \DateTime($timeEntryData['timeInterval']['end']));
            $project = $this->entityManager->getRepository(Project::class)
                ->findOneBy(['externalID' => $timeEntryData['projectId']]);
            $timeEntry->setProject($project);
            $member = $this->entityManager->getRepository(Member::class)
                ->findOneBy(['externalID' => $timeEntryData['userId']]);
            $timeEntry->setMember($member);

            $this->entityManager->persist($timeEntry);
        }

        $this->entityManager->flush();
    }
}
