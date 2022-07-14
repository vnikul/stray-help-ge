<?php

declare(strict_types=1);

namespace App\Model\Request;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;

class CreatePetRequest
{
	#[Length(max: 100)]
	#[NotBlank]
	private string $name;

	#[Length(max: 50)]
	#[NotBlank]
	private string $species;

	#[Optional]
	private string $description;

	#[Type(DateTimeInterface::class)]
	#[Optional]
	private ?DateTimeInterface $anthelmitic_given_at;

	#[Type(DateTimeInterface::class)]
	#[Optional]
	private ?DateTimeInterface $anti_flea_given_at;

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param  string  $name
	 *
	 * @return CreatePetRequest
	 */
	public function setName(string $name): CreatePetRequest
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSpecies(): string
	{
		return $this->species;
	}

	/**
	 * @param  string  $species
	 *
	 * @return CreatePetRequest
	 */
	public function setSpecies(string $species): CreatePetRequest
	{
		$this->species = $species;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
	{
		return $this->description ?? null;
	}

	/**
	 * @param  string  $description
	 *
	 * @return CreatePetRequest
	 */
	public function setDescription(string $description): CreatePetRequest
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return DateTimeInterface|null
	 */
	public function getAnthelmiticGivenAt(): ?DateTimeInterface
	{
		return $this->anthelmitic_given_at ?? null;
	}

	/**
	 * @param  DateTimeInterface  $anthelmitic_given_at
	 *
	 * @return CreatePetRequest
	 */
	public function setAnthelmiticGivenAt(DateTimeInterface $anthelmitic_given_at): CreatePetRequest
	{
		$this->anthelmitic_given_at = $anthelmitic_given_at;
		return $this;
	}

	/**
	 * @return DateTimeInterface|null
	 */
	public function getAntiFleaGivenAt(): ?DateTimeInterface
	{
		return $this->anti_flea_given_at ?? null;
	}

	/**
	 * @param  DateTimeInterface  $anti_flea_given_at
	 *
	 * @return CreatePetRequest
	 */
	public function setAntiFleaGivenAt(DateTimeInterface $anti_flea_given_at): CreatePetRequest
	{
		$this->anti_flea_given_at = $anti_flea_given_at;
		return $this;
	}
}
