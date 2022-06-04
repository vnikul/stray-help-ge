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
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationService
{
    public function __construct(
        private UserRepository $repository,
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $manager,
        private AuthenticationSuccessHandler $successHandler,
    )
    {

    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createUser(CreateUserRequest $request): Response
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

        return $this->successHandler->handleAuthenticationSuccess($user);
    }
}