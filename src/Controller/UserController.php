<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\Request\EditUserRequest;
use App\Model\Response\UserResponse;
use App\Service\UserService;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{

	public function __construct(private readonly UserService $service)
	{
	}

	/**
	 * @OA\Response(
	 *     response=200,
	 *     description="Returns pets by categories",
	 *     @Model(type=UserResponse::class),
	 * )
	 */
	#[Route(path: '/user/edit', methods: ['POST'])]
	public function editUser(#[RequestBody] EditUserRequest $request): JsonResponse
	{
		return $this->json($this->service->editUser($request));
	}

	#[Route(path: '/user/me', methods: ['GET'])]
	public function whoMe(#[CurrentUser] UserInterface $user): JsonResponse
	{
		return $this->json($user);
	}
}