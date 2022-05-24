<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PetCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PetCategoryController extends AbstractController
{

    public function __construct(private PetCategoryService $service)
    {
    }

    #[Route('/petcategory', name: 'app_petcategory')]
    public function categories(): Response
    {
        return $this->json($this->service->getCategories());
    }
}