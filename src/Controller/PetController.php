<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\Request\CreatePetRequest;
use App\Model\Response\PetListResponse;
use App\Service\PetService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
	 *     description="Returns pets by categories",
	 *     @Model(type=Pet::class),
	 * )
	 */
	#[Route(path: '/pet/create', methods: ['POST'])]
	public function createPet(#[RequestBody] CreatePetRequest $request): JsonResponse
	{
		return $this->json($this->service->createPet($request));
	}
}
