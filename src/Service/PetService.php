<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Pet;
use App\Entity\PetImage;
use App\Entity\User;
use App\Exception\PetCategoryNotFoundException;
use App\Exception\ValidationException;
use App\Model\Request\AddPhotosRequest;
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
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PetService
{
	public function __construct(
		private readonly PetRepository $petRepository,
		private readonly PetCategoryRepository $petCategoryRepository,
		private readonly EntityManagerInterface $entityManager,
		private readonly Security $security,
		private readonly UserRepository $userRepository,
		private readonly ValidatorInterface $validator,
		private readonly PetImageUploaderService $imageUploaderService,
		private readonly Packages $packages,
	) {
	}

	public function getAllPets(): PetListResponse
	{
		return new PetListResponse(array_map(
			[$this, 'map'],
			$this->petRepository->getAllPets()
		));
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

	private function map(Pet $pet): PetResponse
	{
		return new PetResponse((string)$pet->getId(), $pet->getName(), $pet->getSpecies(), null, $this->getPetPhotos($pet));
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

	/**
	 * @throws NonUniqueResultException
	 */
	public function editPet(Pet $pet, EditPetRequest $request): PetResponse
	{
		$user = $this->userRepository->find($this->security->getUser()?->getId());

		$this->checkPetOwner($pet, $user);

		$pet
			->setName($request->getName())
			->setSpecies($request->getSpecies())
			->setAntiFleaGivenAt($request->getAntiFleaGivenAt())
			->setAnthelminticGivenAt($request->getAnthelmiticGivenAt())
			->setDescription($request->getDescription());

		$this->entityManager->persist($pet);
		$this->entityManager->flush();

		return $this->petResponse($pet, $user);
	}

	/**
	 * @throws NonUniqueResultException
	 */
	public function addPhotos(Pet $pet, Request $request): PetResponse
	{
		$user = $this->userRepository->find($this->security->getUser()?->getId());

		$this->checkPetOwner($pet, $user);

		$files = $request->files->get('files');

		$fileRequest = (new AddPhotosRequest())->setPhotos($files);
		$errors = $this->validator->validate($fileRequest);
		if (count($errors) > 0) {
			throw new ValidationException($errors);
		}

		/** @var File $file */
		foreach ($fileRequest->getPhotos() as $file) {
			$petImage = $this->imageUploaderService->createForPet($file, $pet);
			$this->entityManager->persist($petImage);
 		}
		$this->entityManager->flush();

		return $this->petResponse($pet, $user)->setLinks($this->getPetPhotos($pet));
	}

	private function checkPetOwner(Pet $pet, User $user): void
	{
		if ((string)$user->getId() !== (string)$pet->getOwner()->getId()) {
			throw new AccessDeniedException();
		}
	}

	public function petResponse (Pet $pet, User $user): PetResponse
	{
		return new PetResponse(
			(string)$pet->getId(),
			$pet->getName(),
			$pet->getSpecies(),
			new UserResponse((string)$user->getId(), $user->getEmail(), $user->getAccountId(), $user->getPhone()),
		);
	}

	public function getPetPhotos(Pet $pet): array
	{
		/** @var []PetImage $images */
		$images = $pet->getImages();
		$links = [];
		foreach ($images as $image){
			$links[] = $this->packages->getUrl($image->getPath());
		}
		return $links;
	}
}
