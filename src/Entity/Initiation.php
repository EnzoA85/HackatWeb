<?php

namespace App\Entity;

use App\Repository\InitiationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InitiationRepository::class)]
class Initiation extends Evenement
{

    #[ORM\Column(nullable: true)]
    private ?int $nbPlaceLimite = null;

    #[ORM\OneToMany(mappedBy: 'Initiation', targetEntity: Participant::class)]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getNbPlaceLimite(): ?int
    {
        return $this->nbPlaceLimite;
    }

    public function setNbPlaceLimite(?int $nbPlaceLimite): self
    {
        $this->nbPlaceLimite = $nbPlaceLimite;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setInitiation($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getInitiation() === $this) {
                $participant->setInitiation(null);
            }
        }

        return $this;
    }
}
