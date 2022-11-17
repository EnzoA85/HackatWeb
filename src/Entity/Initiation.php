<?php

namespace App\Entity;

use App\Repository\InitiationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InitiationRepository::class)]
class Initiation extends Evenement
{

    #[ORM\Column(nullable: true)]
    private ?int $nbPlaceLimite = null;

    public function getNbPlaceLimite(): ?int
    {
        return $this->nbPlaceLimite;
    }

    public function setNbPlaceLimite(?int $nbPlaceLimite): self
    {
        $this->nbPlaceLimite = $nbPlaceLimite;

        return $this;
    }
}
