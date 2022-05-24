<?php

namespace App\Controller;

use App\Repository\PetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PetController extends AbstractController
{

    public function __construct(private PetRepository $petRepository){}

    #[Route('/pet', name: 'app_pet')]
    public function index(): JsonResponse
    {
       $pets =  $this->petRepository->findAll();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PetController.php',
            'pets' => $pets,
        ]);
    }
}
