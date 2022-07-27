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
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PetService
{
	public function __construct(
		private PetRepository $petRepository,
		private PetCategoryRepository $petCategoryRepository,
		private readonly EntityManagerInterface $entityManager,
		private readonly Security $security,
		private readonly UserRepository $userRepository,
		private readonly ValidatorInterface $validator,
		private readonly string $uploadsDir
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

	/**
	 * @throws NonUniqueResultException
	 */
	public function editPet(string $id, EditPetRequest $request): PetResponse
	{
		$pet = $this->petRepository->getPetByID($id);

		if ($pet === null) {
			throw new NotFoundHttpException('Pet not found');
		}

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
	public function addPhotos(string $id, Request $request): PetResponse
	{
		$pet = $this->petRepository->getPetByID($id);

		if ($pet === null) {
			throw new NotFoundHttpException('Pet not found');
		}

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
			$newFilename = Urlizer::urlize(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . uniqid(
					'',
					true
				) . '.' . $file->guessExtension();
			$destination = $this->uploadsDir . '/pets';
			$file->move($destination, $newFilename);
			$petImage = (new PetImage())->setPath($newFilename)->setPet($pet);
			$this->entityManager->persist($petImage);
 		}
		$this->entityManager->flush();


		return $this->petResponse($pet, $user);
	}


	private function checkPetOwner(Pet $pet, User $user): void
	{
		if ((string)$user->getId() !== (string)$pet->getOwner()->getId()) {
			throw new AccessDeniedException();
		}
	}

	private function petResponse (Pet $pet, User $user): PetResponse
	{
		return new PetResponse(
			(string)$pet->getId(),
			$pet->getName(),
			$pet->getSpecies(),
			new UserResponse((string)$user->getId(), $user->getEmail(), $user->getAccountId(), $user->getPhone())
		);
	}
}
