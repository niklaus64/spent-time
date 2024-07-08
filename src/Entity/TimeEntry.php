<?php

namespace App\Entity;

use App\Repository\TimeEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeEntryRepository::class)]
class TimeEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalID = null;

    #[ORM\Column(length: 3000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'timeEntries')]
    private ?Project $project = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'timeEntries')]
    private ?Member $member = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalID(): ?string
    {
        return $this->externalID;
    }

    public function setExternalID(?string $externalID): static
    {
        $this->externalID = $externalID;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(?\DateTimeInterface $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }
}
