<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ApiResource]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalID = null;

    #[ORM\Column(length: 250)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: TimeEntry::class)]
    private ?Collection $timeEntries = null;

    public function __construct()
    {
        $this->timeEntries = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function addTimeEntry(TimeEntry $timeEntry): self
    {
        if (!$this->timeEntries->contains($timeEntry)) {
            $this->timeEntries[] = $timeEntry;
            $timeEntry->setMember($this);
        }

        return $this;
    }

    public function removeTimeEntry(TimeEntry $timeEntry): self
    {
        if ($this->timeEntries->removeElement($timeEntry)) {
            // set the owning side to null (unless already changed)
            if ($timeEntry->getMember() === $this) {
                $timeEntry->setMember(null);
            }
        }

        return $this;
    }
}
