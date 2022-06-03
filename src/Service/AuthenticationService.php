<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\UserExistsException;
use App\Model\Request\CreateUserRequest;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationService
{
    public function __construct(private UserRepository $repository, private UserPasswordHasherInterface $hasher, private EntityManagerInterface $manager)
    {

    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createUser(CreateUserRequest $request): string
    {
        if ($this->repository->existsByEmail($request->getEmail())) {
            throw new UserExistsException();
        }

        $user = (new User())
            ->setEmail($request->getEmail())
            ->setPhone($request->getPhone());

        $user->setPassword($this->hasher->hashPassword($user, $request->getPassword()));

        $this->manager->persist($user);
        $this->manager->flush();

        return (string)$user->getId();
    }
}