<?php

declare(strict_types=1);

namespace App\Model\Response;

class UserResponse
{
	private string $id;
	private string $email;
	private string $accountID;
	private string $phone;

	public function __construct(string $id, string $email, string $accountID, string $phone)
	{
		$this->id = $id;
		$this->email = $email;
		$this->accountID = $accountID;
		$this->phone = $phone;
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
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getAccountID(): string
	{
		return $this->accountID;
	}

	/**
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
	}
}