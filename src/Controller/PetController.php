<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\Request\CreatePetRequest;
use App\Model\Request\EditPetRequest;
use App\Model\Response\PetListResponse;
use App\Service\PetService;
use Doctrine\ORM\NonUniqueResultException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pet;
use OpenApi\Annotations as OA;
use App\Model\Response\ErrorResponse;

class PetController extends AbstractController
{

	public function __construct(private PetService $service)
	{
	}

	/**
	 * @OA\Response(
	 *     response=200,
	 *     description="Returns pets by categories",
	 *     @Model(type=PetListResponse::class),
	 * )
	 *
	 * @OA\Response(
	 *     response=404,
	 *     description="pet category not found",
	 *     @Model(type=ErrorResponse::class)
	 * )
	 */
	#[Route(path: '/pet/category/{id}', methods: ['GET'])]
	public function byCategory(int $id): JsonResponse
	{
		return $this->json($this->service->getPetByCategory($id));
	}

	/**
	 * @OA\Response(
	 *     response=200,
	 *     description="Create a pet",
	 *     @Model(type=Pet::class),
	 * )
	 */
	#[Route(path: '/pet/create', methods: ['POST'])]
	public function createPet(#[RequestBody] CreatePetRequest $request): JsonResponse
	{
		return $this->json($this->service->createPet($request));
	}

	/**
	 * @OA\Response(
	 *     response=200,
	 *     description="Edit a pet",
	 *     @Model(type=Pet::class),
	 * )
	 *
	 *  * @OA\Response(
	 *     response=404,
	 *     description="Pet not found",
	 *     @Model(type=ErrorResponse::class)
	 * )
	 *
	 *  * @OA\Response(
	 *     response=401,
	 *     description="User is not an owner of a pet",
	 *     @Model(type=ErrorResponse::class)
	 * )
	 * @throws NonUniqueResultException
	 */
	#[Route(path: '/pet/edit/{id}', methods: ['POST'])]
	public function editPet(string $id, #[RequestBody] EditPetRequest $request): JsonResponse
	{
		return $this->json($this->service->editPet($id, $request));
	}

	/**
	 * @throws NonUniqueResultException
	 */
	#[Route(path: '/pet/photos/{id}', methods: ['POST'])]
	public function addPhotos(string $id, Request $request): JsonResponse
	{
		return $this->json($this->service->addPhotos($id, $request));
	}

	/**
	 * @throws NonUniqueResultException
	 */
	#[Route(path: '/pet/get/{id}', methods: ['GET'])]
	public function getPet(string $id): JsonResponse
	{
		return $this->json($this->service->getPetByID($id));
	}
}
