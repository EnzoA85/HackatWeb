<?php

namespace App\Entity;

use App\Repository\ConferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConferenceRepository::class)]
class Conference extends Evenement
{

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    #[ORM\ManyToOne(inversedBy: 'lesConferences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Intervenant $intervenant = null;

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getIntervenant(): ?Intervenant
    {
        return $this->intervenant;
    }

    public function setIntervenant(?Intervenant $intervenant): self
    {
        $this->intervenant = $intervenant;

        return $this;
    }
    
}
