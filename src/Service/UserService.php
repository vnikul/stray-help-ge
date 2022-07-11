<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Request\EditUserRequest;
use App\Model\Response\UserResponse;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
	public function __construct(
		private readonly UserRepository $repository,
		private readonly EntityManagerInterface $entityManager,
		private readonly Security $security,
		private readonly UserPasswordHasherInterface $passwordHasher
	) {
	}


	public function editUser(EditUserRequest $request): UserResponse
	{
		$user = $this->repository->find($this->security->getUser()?->getUserIdentifier());

		if ($request->getEmail() !== null) {
			$user->setEmail($request->getEmail());
		}
		if ($request->getAccountID() !== null) {
			$user->setAccountId($request->getAccountId());
		}
//		if ($request->getPassword() !== null)
//		{
//			$hashedPassword = $this->passwordHasher->hashPassword(
//				$user,
//				$request->getPassword()
//			);
//			$user->setPassword($hashedPassword);
//		}
		if ($request->getPhone()){
			$user->setPhone($request->getPhone());
		}
		$this->entityManager->persist($user);
		$this->entityManager->flush();

		return new UserResponse((string)$user->getId(), $user->getEmail(), $user->getAccountId(), $user->getPhone());
	}
}