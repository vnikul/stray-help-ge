<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $species;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $created_at;


    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    /** @var Collection<PetCategory> */
    #[ORM\ManyToMany(targetEntity: PetCategory::class)]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /** @return Collection<PetCategory> */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection|ArrayCollection $categories
     * @return Pet
     */
    public function setCategories(Collection | ArrayCollection $categories): Pet
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeInterface|null $created_at
     * @return Pet
     */
    public function setCreatedAt(?\DateTimeInterface $created_at): Pet
    {
        $this->created_at = $created_at;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(string $species): self
    {
        $this->species = $species;

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
}
