<?php

namespace App\Entity;

use App\Repository\PetRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;
use Symfony\Component\Uid\Uuid;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
	/**
	 * @OA\Property(type="string")
	 */
	#[ORM\Id]
	#[ORM\Column(type: "uuid", unique: true, columnDefinition: "DEFAULT gen_random_uuid()")]
	#[ORM\GeneratedValue(strategy: "CUSTOM")]
	#[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
	private Uuid $id;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $species;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTimeInterface $created_at;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

	#[ORM\Column(type: 'date', nullable: true)]
	private ?DateTimeInterface $anthelmintic_given_at;

	#[ORM\Column(type: 'date', nullable: true)]
	private ?DateTimeInterface $anti_flea_given_at;

    /** @var Collection<PetCategory> */
    #[ORM\ManyToMany(targetEntity: PetCategory::class)]
    private Collection $categories;

	#[ORM\JoinColumn(nullable: false)]
	#[ORM\ManyToOne(targetEntity: User::class)]
	private User $owner;

	/** @var Collection<PetImage> */
	#[ORM\JoinColumn(nullable: false)]
	#[ORM\OneToMany(mappedBy: 'pet', targetEntity: PetImage::class)]
	private Collection $images;

	#[ORM\PrePersist]
	public function setCreatedAtValue(): void
	{
		$this->created_at = new DateTimeImmutable();
	}

    public function __construct()
    {
        $this->categories = new ArrayCollection();
		$this->images = new ArrayCollection();
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
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param DateTimeInterface|null $created_at
     * @return Pet
     */
    public function setCreatedAt(?DateTimeInterface $created_at): Pet
    {
        $this->created_at = $created_at;
        return $this;
    }


    public function getId(): mixed
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

	/**
	 * @return DateTimeInterface
	 */
	public function getAnthelminticGivenAt(): DateTimeInterface
	{
		return $this->anthelmintic_given_at;
	}

	/**
	 * @param  DateTimeInterface|null  $anthelmintic_given_at
	 *
	 * @return Pet
	 */
	public function setAnthelminticGivenAt(?DateTimeInterface $anthelmintic_given_at): Pet
	{
		$this->anthelmintic_given_at = $anthelmintic_given_at;
		return $this;
	}

	/**
	 * @return DateTimeInterface
	 */
	public function getAntiFleaGivenAt(): DateTimeInterface
	{
		return $this->anti_flea_given_at;
	}

	/**
	 * @param  DateTimeInterface|null  $anti_flea_given_at
	 *
	 * @return Pet
	 */
	public function setAntiFleaGivenAt(?DateTimeInterface $anti_flea_given_at): Pet
	{
		$this->anti_flea_given_at = $anti_flea_given_at;
		return $this;
	}

	/**
	 * @return User
	 */
	public function getOwner(): User
	{
		return $this->owner;
	}

	/**
	 * @param  User  $owner
	 * @return Pet
	 */
	public function setOwner(User $owner): Pet
	{
		$this->owner = $owner;
		return $this;
	}

	/**
	 * @return Collection
	 */
	public function getImages(): Collection
	{
		return $this->images;
	}

	/**
	 * @param  Collection  $images
	 * @return Pet
	 */
	public function setImages(Collection $images): Pet
	{
		$this->images = $images;
		return $this;
	}

	public function addImage(PetImage $image)
	{
		$this->images[] = $image;
		return $this;
	}
}
