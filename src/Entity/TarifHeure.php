<?php

namespace App\Entity;

use App\Repository\TarifHeureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TarifHeureRepository::class)]
class TarifHeure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    #[Assert\NotNull]
    #[Assert\Regex(pattern: "/^\d+(\.\d{1,2})?$/", message: "Le tarif doit être un nombre valide avec jusqu'à deux décimales.")]
    #[Assert\Range(min: 1, minMessage: "Le tarif doit être supérieur ou égal à 1.")]
    private ?string $tarif = null;

    #[ORM\OneToMany(targetEntity: Terrains::class, mappedBy: 'tarifHeure')]
    private Collection $terrain;

    public function __construct()
    {
        $this->terrain = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarif(): ?string
    {
        return $this->tarif;
    }

    public function setTarif(string $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * @return Collection<int, Terrains>
     */
    public function getTerrain(): Collection
    {
        return $this->terrain;
    }

    public function addTerrain(Terrains $terrain): static
    {
        if (!$this->terrain->contains($terrain)) {
            $this->terrain->add($terrain);
            $terrain->setTarifHeure($this);
        }

        return $this;
    }

    public function removeTerrain(Terrains $terrain): static
    {
        if ($this->terrain->removeElement($terrain)) {
            // set the owning side to null (unless already changed)
            if ($terrain->getTarifHeure() === $this) {
                $terrain->setTarifHeure(null);
            }
        }

        return $this;
    }
}
