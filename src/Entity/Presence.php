<?php

namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'json')]
    private $present = [];

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'presences')]
    private $user;

    #[ORM\Column(type: 'integer')]
    private $annee;

    #[ORM\ManyToOne(targetEntity: Filier::class, inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    private $filier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresent(): ?array
    {
        return $this->present;
    }

    public function setPresent(array $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getFilier(): ?Filier
    {
        return $this->filier;
    }

    public function setFilier(?Filier $filier): self
    {
        $this->filier = $filier;

        return $this;
    }


}
