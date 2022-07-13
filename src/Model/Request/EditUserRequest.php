<?php

declare(strict_types=1);

namespace App\Model\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Optional;

class EditUserRequest
{
	#[Email]
	#[Optional]
	#[Length(max: 255)]
	private string $email;

	#[Optional]
	#[Length(min: 6,max: 255)]
	private string $password;

	#[Optional]
	#[Length(max: 50)]
	private string $phone;

	#[Optional]
	#[Length(max: 255)]
	private string $accountID;


	/**
	 * @return string|null
	 */
	public function getEmail(): ?string
	{
		return $this->email ?? null;
	}

	/**
	 * @param string $email
	 * @return EditUserRequest
	 */
	public function setEmail(string $email): EditUserRequest
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPhone(): ?string
	{
		return $this->phone ?? null;
	}

	/**
	 * @param string $phone
	 * @return EditUserRequest
	 */
	public function setPhone(string $phone): EditUserRequest
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPassword(): ?string
	{
		return $this->password ?? null;
	}

	/**
	 * @param string $password
	 * @return EditUserRequest
	 */
	public function setPassword(string $password): EditUserRequest
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAccountID(): ?string
	{
		return $this->accountID ?? null;
	}

	/**
	 * @param  string  $accountID
	 * @return EditUserRequest
	 */
	public function setAccountID(string $accountID): EditUserRequest
	{
		$this->accountID = $accountID;
		return $this;
	}
}

