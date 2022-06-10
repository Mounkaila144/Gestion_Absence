<?php

namespace App\Entity;

use App\Repository\FilierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilierRepository::class)]
class Filier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'filier', targetEntity: Etudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'filier', targetEntity: Presence::class)]
    private $presences;

    public function __toString(): string
    {
        return $this->getNom();
    }


    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->presences = new ArrayCollection();
        $this->presencess = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setFilier($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getFilier() === $this) {
                $etudiant->setFilier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): self
    {
        if (!$this->presences->contains($presence)) {
            $this->presences[] = $presence;
            $presence->setFilier($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): self
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getFilier() === $this) {
                $presence->setFilier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresencess(): Collection
    {
        return $this->presencess;
    }

}
