<?php

namespace App\Entity;

use App\Repository\IntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IntervenantRepository::class)]
class Intervenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\OneToMany(mappedBy: 'intervenant', targetEntity: Conference::class)]
    private Collection $lesConferences;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $mail = null;

    public function __construct()
    {
        $this->lesConferences = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Conference>
     */
    public function getLesConferences(): Collection
    {
        return $this->lesConferences;
    }

    public function addLesConference(Conference $lesConference): self
    {
        if (!$this->lesConferences->contains($lesConference)) {
            $this->lesConferences->add($lesConference);
            $lesConference->setIntervenant($this);
        }

        return $this;
    }

    public function removeLesConference(Conference $lesConference): self
    {
        if ($this->lesConferences->removeElement($lesConference)) {
            // set the owning side to null (unless already changed)
            if ($lesConference->getIntervenant() === $this) {
                $lesConference->setIntervenant(null);
            }
        }

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
}
