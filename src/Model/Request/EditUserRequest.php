<?php

declare(strict_types=1);

namespace App\Model\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class EditUserRequest
{
	#[Email]
	#[Length(max: 255)]
	private string $email = '';

	#[Length(max: 50)]
	private string $phone = '';

	#[Length(max: 255)]
	private string $accountID = '';


	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
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
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
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
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
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
	 * @return string
	 */
	public function getAccountID(): string
	{
		return $this->accountID;
	}

	/**
	 * @param  string  $acountID
	 *
	 * @return EditUserRequest
	 */
	public function setAccountID(string $accountID): EditUserRequest
	{
		$this->accountID = $accountID;
		return $this;
	}
}

