<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 128, unique: true)]
    private ?string $mail = null;

    #[ORM\Column(name : "dateNaissance", type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(name : "lienPortfolio", length: 255)]
    private ?string $lienPortfolio = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 10)]
    private ?string $tel = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private $roles = [];

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Inscription::class)]
    private Collection $lesInscriptions;

    #[ORM\ManyToMany(targetEntity: Hackathon::class)]
    private Collection $favoris;

    public function __construct()
    {
        $this->lesInscriptions = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLienPortfolio(): ?string
    {
        return $this->lienPortfolio;
    }

    public function setLienPortfolio(string $lienPortfolio): self
    {
        $this->lienPortfolio = $lienPortfolio;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->mdp = $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->mdp;
    }

    public function getmdp(): ?string
    {
        return $this->mdp;
    }

    public function setmdp(string $password): self
    {
        $this->mdp = $password;
        return $this;
    }

    //Fonction retournant le login (ici le mail)
    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @return Collection<int, Inscription>
     */
    public function getLesInscriptions(): Collection
    {
        return $this->lesInscriptions;
    }

    public function addLesInscription(Inscription $lesInscription): self
    {
        if (!$this->lesInscriptions->contains($lesInscription)) {
            $this->lesInscriptions->add($lesInscription);
            $lesInscription->setUtilisateur($this);
        }

        return $this;
    }

    public function removeLesInscription(Inscription $lesInscription): self
    {
        if ($this->lesInscriptions->removeElement($lesInscription)) {
            // set the owning side to null (unless already changed)
            if ($lesInscription->getUtilisateur() === $this) {
                $lesInscription->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hackathon>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Hackathon $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(Hackathon $favori): self
    {
        $this->favoris->removeElement($favori);

        return $this;
    }
}
