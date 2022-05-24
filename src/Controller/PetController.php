<?php

namespace App\Controller;

use App\Repository\PetRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\PetCategoryListResponse;
use OpenApi\Attributes as OA;

class PetController extends AbstractController
{

    public function __construct(private PetRepository $petRepository)
    {
    }

    #[Route('/pet', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $pets = $this->petRepository->findAll();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PetController.php',
            'pets' => $pets,
        ]);
    }
}
