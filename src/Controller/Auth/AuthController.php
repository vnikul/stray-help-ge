<?php

namespace App\Controller\Auth;

use App\Attribute\RequestBody;
use App\Model\Request\CreateUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }


    #[Route('/auth/signup', methods: ['POST'])]
    public function signUp(#[RequestBody] CreateUserRequest $request): JsonResponse
    {
        return $this->json([
            'request' => $request,
            'path' => 'src/Controller/AuthController.php',
        ]);
    }
}
