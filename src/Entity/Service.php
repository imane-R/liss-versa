<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?float $CheveuxCourtsPrix = null;

    #[ORM\Column(nullable: true)]
    private ?float $cheveuxMoyensPrix = null;

    #[ORM\Column(nullable: true)]
    private ?float $cheveauxLongsPrix = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCheveuxCourtsPrix(): ?float
    {
        return $this->CheveuxCourtsPrix;
    }

    public function setCheveuxCourtsPrix(?float $CheveuxCourtsPrix): self
    {
        $this->CheveuxCourtsPrix = $CheveuxCourtsPrix;

        return $this;
    }

    public function getCheveuxMoyensPrix(): ?float
    {
        return $this->cheveuxMoyensPrix;
    }

    public function setCheveuxMoyensPrix(?float $cheveuxMoyensPrix): self
    {
        $this->cheveuxMoyensPrix = $cheveuxMoyensPrix;

        return $this;
    }

    public function getCheveauxLongsPrix(): ?float
    {
        return $this->cheveauxLongsPrix;
    }

    public function setCheveauxLongsPrix(?float $cheveauxLongsPrix): self
    {
        $this->cheveauxLongsPrix = $cheveauxLongsPrix;

        return $this;
    }
}
