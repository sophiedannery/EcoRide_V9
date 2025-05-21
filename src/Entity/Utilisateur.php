<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use \DateTimeInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_utilisateur")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(name: "mot_de_passe", type: "string", length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?DateTimeInterface $dateCreation = null;

    #[ORM\Column]
    private ?int $credits = null;

    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\OneToMany(targetEntity: Vehicule::class, mappedBy: 'utilisateur')]
    private Collection $immatriculation;

    #[ORM\OneToMany(targetEntity: Trajet::class, mappedBy: 'chauffeur', orphanRemoval: true)]
    private Collection $trajets;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'passager')]
    private Collection $reservations;

    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'employeValideur')]
    private Collection $avis;

    #[ORM\OneToMany(targetEntity: Suspension::class, mappedBy: 'utilisateur')]
    private Collection $suspensions;

    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'utilisateur')]
    private Collection $transactions;

    public function __construct()
    {
        $this->immatriculation = new ArrayCollection();
        $this->trajets = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->suspensions = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): self
    {
        $this->credits = $credits;
        return $this;
    }

    // ---------- Security methods ----------

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        return array_unique([...$this->roles, 'ROLE_USER']);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Clear temporary sensitive data, if any
    }

    // ---------- Relation getters/setters ----------

    public function getImmatriculation(): Collection
    {
        return $this->immatriculation;
    }

    public function addImmatriculation(Vehicule $vehicule): self
    {
        if (!$this->immatriculation->contains($vehicule)) {
            $this->immatriculation->add($vehicule);
            $vehicule->setUtilisateur($this);
        }

        return $this;
    }

    public function removeImmatriculation(Vehicule $vehicule): self
    {
        if ($this->immatriculation->removeElement($vehicule)) {
            if ($vehicule->getUtilisateur() === $this) {
                $vehicule->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getTrajets(): Collection
    {
        return $this->trajets;
    }

    public function addTrajet(Trajet $trajet): self
    {
        if (!$this->trajets->contains($trajet)) {
            $this->trajets->add($trajet);
            $trajet->setChauffeur($this);
        }

        return $this;
    }

    public function removeTrajet(Trajet $trajet): self
    {
        if ($this->trajets->removeElement($trajet)) {
            if ($trajet->getChauffeur() === $this) {
                $trajet->setChauffeur(null);
            }
        }

        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setPassager($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getPassager() === $this) {
                $reservation->setPassager(null);
            }
        }

        return $this;
    }

    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setEmployeValideur($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            if ($avi->getEmployeValideur() === $this) {
                $avi->setEmployeValideur(null);
            }
        }

        return $this;
    }

    public function getSuspensions(): Collection
    {
        return $this->suspensions;
    }

    public function addSuspension(Suspension $suspension): self
    {
        if (!$this->suspensions->contains($suspension)) {
            $this->suspensions->add($suspension);
            $suspension->setUtilisateur($this);
        }

        return $this;
    }

    public function removeSuspension(Suspension $suspension): self
    {
        if ($this->suspensions->removeElement($suspension)) {
            if ($suspension->getUtilisateur() === $this) {
                $suspension->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            if ($transaction->getUtilisateur() === $this) {
                $transaction->setUtilisateur(null);
            }
        }

        return $this;
    }
}
