<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PetCategoryService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\PetCategoryListResponse;
use OpenApi\Annotations as OA;

class PetCategoryController extends AbstractController
{

    public function __construct(private PetCategoryService $service)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns book categories",
     *     @Model(type=PetCategoryListResponse::class)
     * )
     */
    #[Route('/petcategory', methods: ['GET'])]
    public function categories(): Response
    {
        return $this->json($this->service->getCategories());
    }
}