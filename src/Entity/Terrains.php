<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\TerrainsRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TerrainsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Terrains
{
    use DateTimeTrait,
        EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'le nom ne peut pas faire plus de {{ limit }}'
    )]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $description = null;

    

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'le type de terrain ne peut pas faire plus de {{ limit }}'
    )]
    #[Assert\NotBlank()]
    private ?string $typeTerrain = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?float $taille = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    

    public function getTypeTerrain(): ?string
    {
        return $this->typeTerrain;
    }

    public function setTypeTerrain(string $typeTerrain): static
    {
        $this->typeTerrain = $typeTerrain;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(float $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

}
