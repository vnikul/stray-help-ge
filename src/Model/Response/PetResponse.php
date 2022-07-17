<?php

declare(strict_types=1);

namespace App\Model\Response;

class PetResponse
{
	private string $id;
	private string $name;
	private string $species;
	private UserResponse $user;

	public function __construct(string $id, string $name, string $species, UserResponse $userResponse)
	{
		$this->id = $id;
		$this->name = $name;
		$this->species = $species;
		$this->user = $userResponse;
	}

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getSpecies(): string
	{
		return $this->species;
	}

	/**
	 * @return UserResponse
	 */
	public function getUser(): UserResponse
	{
		return $this->user;
	}
}