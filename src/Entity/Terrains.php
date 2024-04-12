<?php

namespace App\Entity;



use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\TerrainsRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TerrainsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Terrains
{
    use DateTimeTrait,
        EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Gedmo\Slug(fields: ['nom'])]
    private ?string $slug = null;

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

    #[Vich\UploadableField(mapping: 'terrain_image', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Assert\Image(
        mimeTypes: ['image/*'],
        maxSize : '8M',
        detectCorrupted: true
    )]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]

    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;


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

    #[ORM\ManyToOne(inversedBy: 'terrains')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Complexes $complexe = null;

    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'terrain')]
    private Collection $avis;

    #[ORM\ManyToOne(inversedBy: 'terrain')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TarifHeure $tarifHeure = null;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->avis = new ArrayCollection();
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

    public function getComplexe(): ?Complexes
    {
        return $this->complexe;
    }

    public function setComplexe(?Complexes $complexe): static
    {
        $this->complexe = $complexe;

        return $this;
    }



    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setTerrain($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getTerrain() === $this) {
                $avi->setTerrain(null);
            }
        }

        return $this;
    }

    public function getTarifHeure(): ?TarifHeure
    {
        return $this->tarifHeure;
    }

    public function setTarifHeure(?TarifHeure $tarifHeure): static
    {
        $this->tarifHeure = $tarifHeure;

        return $this;
    }
}
