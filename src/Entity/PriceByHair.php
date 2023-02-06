<?php

namespace App\Entity;

use App\Repository\PriceByHairRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceByHairRepository::class)]
class PriceByHair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'priceByHairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\ManyToOne(inversedBy: 'priceByHairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HairType $hairType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getHairType(): ?HairType
    {
        return $this->hairType;
    }

    public function setHairType(?HairType $hairType): self
    {
        $this->hairType = $hairType;

        return $this;
    }
}
