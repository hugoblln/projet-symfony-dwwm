<?php

namespace App\Entity;

use App\Entity\Users;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\ComplexesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ComplexesRepository::class)]
#[UniqueEntity(fields: 'nom', message: 'le nom est deja utilisé par un autre complexe')]
#[ORM\HasLifecycleCallbacks]
class Complexes
{

    use DateTimeTrait,
        EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'le nom du complexe ne peut pas faire plus de {{ limit }}'
    )]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'l\'adresse ne peut pas faire plus de {{ limit }}'
    )]
    #[Assert\NotBlank()]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column(length: 10)]
    #[Assert\Length(
        max: 10,
        maxMessage: 'le numero de telephone ne peut pas faire plus de {{ limit }} chiffres'
    )]
    #[Assert\NotBlank()]
    #[Assert\Regex(
        pattern: '/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/',
        message: "Le numéro de téléphone doit être au format valide"
    )]
    private ?string $telephone = null;

    #[ORM\OneToMany(targetEntity: Terrains::class, mappedBy: 'complexe')]
    private Collection $terrains;

    #[ORM\Column(length: 255)]
    private ?string $Ville = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureFermeture = null;

    #[ORM\ManyToOne(inversedBy: 'complexes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $Proprietaire = null;


    public function __construct()
    {
        $this->terrains = new ArrayCollection();
    }

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Terrains>
     */
    public function getTerrains(): Collection
    {
        return $this->terrains;
    }

    public function addTerrain(Terrains $terrain): static
    {
        if (!$this->terrains->contains($terrain)) {
            $this->terrains->add($terrain);
            $terrain->setComplexe($this);
        }

        return $this;
    }

    public function removeTerrain(Terrains $terrain): static
    {
        if ($this->terrains->removeElement($terrain)) {
            // set the owning side to null (unless already changed)
            if ($terrain->getComplexe() === $this) {
                $terrain->setComplexe(null);
            }
        }

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getHeureOuverture(): ?\DateTimeInterface
    {
        return $this->HeureOuverture;
    }

    public function setHeureOuverture(\DateTimeInterface $HeureOuverture): static
    {
        $this->HeureOuverture = $HeureOuverture;

        return $this;
    }

    public function getHeureFermeture(): ?\DateTimeInterface
    {
        return $this->HeureFermeture;
    }

    public function setHeureFermeture(\DateTimeInterface $HeureFermeture): static
    {
        $this->HeureFermeture = $HeureFermeture;

        return $this;
    }

    public function getProprietaire(): ?users
    {
        return $this->Proprietaire;
    }

    public function setProprietaire(?users $Propriétaire): static
    {
        $this->Proprietaire = $Propriétaire;

        return $this;
    }


}
