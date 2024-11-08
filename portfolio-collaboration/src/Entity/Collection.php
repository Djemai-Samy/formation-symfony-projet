<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Collection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, length: 100)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, length: 300)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $isPublic = false;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::TEXT, length: 200, nullable: true)]
    private ?string $cover = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private $tags = [];

    #[ORM\Column(type: Types::TEXT, length: 50, nullable: true)]
    private ?string $categorie = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'collections')]
    private $utilisateur;


    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'collection', cascade: ['persist', 'remove'])]
    private DoctrineCollection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(?bool $isPublic): self
    {
        $this->isPublic = $isPublic;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(?DateTimeImmutable $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;
        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getUtilisateur()
    {
        return $this->utilisateur;
    }


    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function addPost(Post $post)
    {
        $this->posts->add($post);
        $post->setCollection($this);

        return $this;
    }
}
