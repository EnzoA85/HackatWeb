<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name : "texteLibre", length: 255)]
    private ?string $texteLibre = null;

    #[ORM\Column(name : "dateInscription", type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToOne(inversedBy: 'lesInscriptions')]
    #[ORM\JoinColumn(name : "idHackathon", nullable: false)]
    private ?Hackathon $hackathon = null;

    #[ORM\ManyToOne(inversedBy: 'lesInscriptions')]
    #[ORM\JoinColumn(name : "idUtilisateur", nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexteLibre(): ?string
    {
        return $this->texteLibre;
    }

    public function setTexteLibre(?string $texteLibre): self
    {
        $this->texteLibre = $texteLibre;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getHackathon(): ?Hackathon
    {
        return $this->hackathon;
    }

    public function setHackathon(?Hackathon $hackathon): self
    {
        $this->hackathon = $hackathon;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
