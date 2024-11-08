<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, nullable: false)]
    private ?string $email = null;

    #[ORM\Column(length: 50, nullable: false)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emploi = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteURL = null;


    #[ORM\Column]
    private array $roles = [];


    #[ORM\Column]
    private ?string $password = null;


    #[ORM\OneToMany(
        targetEntity: Collection::class,
        mappedBy: "utilisateur",
        cascade: ['persist', 'remove']
    )]
    private $collections;

    public function __construct()
    {
        $this->collections = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getEmploi(): ?string
    {
        return $this->emploi;
    }

    public function setEmploi(?string $emploi): static
    {
        $this->emploi = $emploi;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSiteURL(): ?string
    {
        return $this->siteURL;
    }

    public function setSiteURL(?string $siteURL): static
    {
        $this->siteURL = $siteURL;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void {}

    public function getCollections()
    {
        return $this->collections;
    }

    public function addCollection(Collection $collection)
    {
        $collection->setUtilisateur($this);
        $this->collections->add($collection);

        return $this->collections;
    }
}
