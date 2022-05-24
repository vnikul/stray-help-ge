<?php

namespace App\Entity;

use App\Repository\PetCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetCategoryRepository::class)]
class PetCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $type;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return PetCategory
     */
    public function setType(?string $type): PetCategory
    {
        $this->type = $type;
        return $this;
    }

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $slug;

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return PetCategory
     */
    public function setSlug(?string $slug): PetCategory
    {
        $this->slug = $slug;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): PetCategory
    {
        $this->id = $id;
        return $this;
    }
}
