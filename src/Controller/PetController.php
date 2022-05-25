<?php

namespace App\Controller;

use App\Model\PetListResponse;
use App\Service\PetService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\PetCategoryListResponse;
use OpenApi\Annotations as OA;
use App\Model\ErrorResponse;

class PetController extends AbstractController
{

    public function __construct(private PetService $service)
    {
    }

//    #[Route('/pet', methods: ['GET'])]
//    public function index(): JsonResponse
//    {
//        $pets = $this->petRepository->findAll();
//
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/PetController.php',
//            'pets' => $pets,
//        ]);
//    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns pets by categories",
     *     @Model(type=PetListResponse::class),
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="pet categort not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/pet/category/{id}', methods: ['GET'])]
    public function byCategory(int $id): JsonResponse
    {
        return $this->json($this->service->getPetByCategory($id));
    }
}
