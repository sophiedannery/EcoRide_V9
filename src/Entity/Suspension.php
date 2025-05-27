<?php

namespace App\Entity;

use App\Repository\SuspensionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuspensionRepository::class)]
class Suspension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'suspensions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'suspensions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $administrateur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateSuspension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'suspensions')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'suspensions')]
    private ?User $admini = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getAdministrateur(): ?Utilisateur
    {
        return $this->administrateur;
    }

    public function setAdministrateur(?Utilisateur $administrateur): static
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getDateSuspension(): ?\DateTime
    {
        return $this->dateSuspension;
    }

    public function setDateSuspension(\DateTime $dateSuspension): static
    {
        $this->dateSuspension = $dateSuspension;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAdmini(): ?User
    {
        return $this->admini;
    }

    public function setAdmini(?User $admini): static
    {
        $this->admini = $admini;

        return $this;
    }
}
