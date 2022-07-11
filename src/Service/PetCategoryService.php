<?php

namespace App\Service;

use App\Entity\PetCategory;
use App\Model\Response\PetCategoryListItem;
use App\Model\Response\PetCategoryListResponse;
use App\Repository\PetCategoryRepository;
use Doctrine\Common\Collections\Criteria;

class PetCategoryService
{
    public function __construct(private PetCategoryRepository $petCategoryRepository)
    {
    }

    public function getCategories(): PetCategoryListResponse
    {
        $categories = $this->petCategoryRepository->findBy([], ['type' => Criteria::ASC]);

        $items = array_map(
            static fn(PetCategory $petCategory) =>
                new PetCategoryListItem($petCategory->getId(), $petCategory->getType(), $petCategory->getSlug()
            ),
            $categories);

        return new PetCategoryListResponse($items);
    }
}