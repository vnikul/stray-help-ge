<?php

declare(strict_types=1);

namespace App\Model\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateUserRequest
{
    #[Email]
    #[NotBlank]
    private string $email;

    #[NotBlank]
    private string $phone;

    #[NotBlank]
    #[Length(min: 8)]
    private string $password;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CreateUserRequest
     */
    public function setEmail(string $email): CreateUserRequest
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
     * @return CreateUserRequest
     */
    public function setPhone(string $phone): CreateUserRequest
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
     * @return CreateUserRequest
     */
    public function setPassword(string $password): CreateUserRequest
    {
        $this->password = $password;
        return $this;
    }
}
