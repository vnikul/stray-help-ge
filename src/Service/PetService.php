<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Pet;
use App\Exception\PetCategoryNotFoundException;
use App\Model\Request\CreatePetRequest;
use App\Model\Request\EditPetRequest;
use App\Model\Response\PetListItem;
use App\Model\Response\PetListResponse;
use App\Model\Response\PetResponse;
use App\Model\Response\UserResponse;
use App\Repository\PetCategoryRepository;
use App\Repository\PetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class PetService
{
	public function __construct(
		private PetRepository $petRepository,
		private PetCategoryRepository $petCategoryRepository,
		private readonly EntityManagerInterface $entityManager,
		private readonly Security $security,
		private readonly UserRepository $userRepository,
	) {
	}

	public function getPetByCategory(int $categoryID): PetListResponse
	{
		if (!$this->petCategoryRepository->existsByID($categoryID)) {
			throw new PetCategoryNotFoundException();
		}

		return new PetListResponse(
			array_map(
				[$this, 'map'],
				$this->petRepository->getPetByCategory($categoryID)
			)
		);
	}

	private function map(Pet $pet): PetListItem
	{
		return new PetListItem($pet->getId(), $pet->getName(), $pet->getSpecies(), $pet->getDescription());
	}

	public function createPet(CreatePetRequest $request): PetResponse
	{
		$user = $this->userRepository->find($this->security->getUser()?->getId());
		$pet = (new Pet())
			->setSpecies($request->getSpecies())
			->setDescription($request->getDescription())
			->setName($request->getName())
			->setOwner($user)
			->setAnthelminticGivenAt($request->getAnthelmiticGivenAt())
			->setAntiFleaGivenAt($request->getAntiFleaGivenAt());

		$this->entityManager->persist($pet);
		$this->entityManager->flush();

		return new PetResponse(
			(string)$pet->getId(),
			$pet->getName(),
			$pet->getSpecies(),
			new UserResponse((string)$user->getId(), $user->getEmail(), $user->getAccountId(), $user->getPhone())
		);
	}

	public function editPet(string $id, EditPetRequest $request): PetResponse
	{
		$pet = $this->petRepository->find($id);

		if ($pet === null) {
			throw new NotFoundHttpException('Pet not found');
		}

		$user = $this->userRepository->find($this->security->getUser()?->getId());

		if ((string)$user->getId() !== $pet->getOwner()->getId()) {
			throw new AccessDeniedException();
		}

		$pet
			->setName($request->getName())
			->setSpecies($request->getSpecies())
			->setAntiFleaGivenAt($request->getAntiFleaGivenAt())
			->setAnthelminticGivenAt($request->getAnthelmiticGivenAt())
			->setDescription($request->getDescription());

		return new PetResponse(
			(string)$pet->getId(),
			$pet->getName(),
			$pet->getSpecies(),
			new UserResponse((string)$user->getId(), $user->getEmail(), $user->getAccountId(), $user->getPhone())
		);
	}
}
