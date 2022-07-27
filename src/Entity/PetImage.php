<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PetFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PetFileRepository::class)]
class PetImage
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string')]
	private ?string $path;

	#[ORM\ManyToOne(targetEntity: Pet::class)]
	private Pet $pet;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param  mixed  $id
	 *
	 * @return PetImage
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPath(): ?string
	{
		return $this->path;
	}

	/**
	 * @param  string|null  $path
	 *
	 * @return PetImage
	 */
	public function setPath(?string $path): PetImage
	{
		$this->path = $path;
		return $this;
	}

	/**
	 * @return Pet
	 */
	public function getPet(): Pet
	{
		return $this->pet;
	}

	/**
	 * @param  Pet  $pet
	 *
	 * @return PetImage
	 */
	public function setPet(Pet $pet): PetImage
	{
		$this->pet = $pet;
		return $this;
	}
}