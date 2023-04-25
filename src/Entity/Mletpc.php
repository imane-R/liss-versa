<?php

namespace App\Entity;

use App\Repository\MletpcRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MletpcRepository::class)]
class Mletpc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $mentionslegales = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $politiquesdeconfidentialite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMentionslegales(): ?string
    {
        return $this->mentionslegales;
    }

    public function setMentionslegales(string $mentionslegales): self
    {
        $this->mentionslegales = $mentionslegales;

        return $this;
    }

    public function getPolitiquesdeconfidentialite(): ?string
    {
        return $this->politiquesdeconfidentialite;
    }

    public function setPolitiquesdeconfidentialite(string $politiquesdeconfidentialite): self
    {
        $this->politiquesdeconfidentialite = $politiquesdeconfidentialite;

        return $this;
    }
}
