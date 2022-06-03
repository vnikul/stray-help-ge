<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Attribute\RequestBody;
use App\Model\Request\CreateUserRequest;
use App\Service\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class AuthController extends AbstractController
{

    public function __construct(private AuthenticationService $service) {}
//    #[Route('/api/login', name: 'app_auth')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/AuthController.php',
//        ]);
//    }

    /**
     * @OA\Response(
     *      response=200,
     *     description="create a user"
     * )
     */
    #[Route('/auth/signup', methods: ['POST'])]
    public function signUp(#[RequestBody] CreateUserRequest $request): JsonResponse
    {
        $id = $this->service->createUser($request);
        return $this->json([
            'request' => $request,
            'path' => 'src/Controller/AuthController.php',
            'id' => $id,
        ]);
    }
}
