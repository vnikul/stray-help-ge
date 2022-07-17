<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true, columnDefinition: "DEFAULT gen_random_uuid()")]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    private mixed $id;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private ?string $phone;

    #[ORM\Column(type: 'string', unique: true)]
    private ?string $email;

    #[ORM\Column(type: 'string')]
    private ?string $password;

    #[ORM\Column(type: 'string', unique: true, nullable: true)]
    private ?string $account_id;

	/** @var Collection<Pet> */
	#[ORM\OneToMany(mappedBy: 'owner_id', targetEntity: Pet::class)]
	private Collection $pets;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId(mixed $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return User
     */
    public function setPhone(?string $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountId(): ?string
    {
        return $this->account_id;
    }

    /**
     * @param string|null $account_id
     * @return User
     */
    public function setAccountId(?string $account_id): User
    {
        $this->account_id = $account_id;
        return $this;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
        return;
    }

    public function getUserIdentifier(): string
    {
       return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

	/** @return Collection<Pet> */
	public function getPets(): Collection
	{
		return $this->pets;
	}

	/**
	 * @param  Collection|ArrayCollection  $pets
	 *
	 * @return User
	 */
	public function setPets(Collection | ArrayCollection $pets): User
	{
		$this->pets = $pets;
		return $this;
	}
}
