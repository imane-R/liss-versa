<?php

namespace App\Entity;

use App\Repository\HairTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HairTypeRepository::class)]
class HairType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeHair = null;

    #[ORM\OneToMany(mappedBy: 'hairType', targetEntity: PriceByHair::class)]
    private Collection $priceByHairs;

    public function __construct()
    {
        $this->priceByHairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeHair(): ?string
    {
        return $this->typeHair;
    }

    public function setTypeHair(string $typeHair): self
    {
        $this->typeHair = $typeHair;

        return $this;
    }

    /**
     * @return Collection<int, PriceByHair>
     */
    public function getPriceByHairs(): Collection
    {
        return $this->priceByHairs;
    }

    public function addPriceByHair(PriceByHair $priceByHair): self
    {
        if (!$this->priceByHairs->contains($priceByHair)) {
            $this->priceByHairs->add($priceByHair);
            $priceByHair->setHairType($this);
        }

        return $this;
    }

    public function removePriceByHair(PriceByHair $priceByHair): self
    {
        if ($this->priceByHairs->removeElement($priceByHair)) {
            // set the owning side to null (unless already changed)
            if ($priceByHair->getHairType() === $this) {
                $priceByHair->setHairType(null);
            }
        }

        return $this;
    }
}
