<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Pet;
use App\Exception\PetCategoryNotFoundException;
use App\Model\Response\PetListItem;
use App\Model\Response\PetListResponse;
use App\Repository\PetCategoryRepository;
use App\Repository\PetRepository;

class PetService
{
    public function __construct(private PetRepository $petRepository, private PetCategoryRepository $petCategoryRepository)
    {
    }

    public function getPetByCategory(int $categoryID): PetListResponse
    {
        if (!$this->petCategoryRepository->existsByID($categoryID)) {
            throw new PetCategoryNotFoundException();
        }

        return new PetListResponse(
            array_map(
                [$this, 'map'],
                $this->petRepository->getPetByCategory($categoryID)
            )
        );
    }

    private function map(Pet $pet): PetListItem
    {
        return new PetListItem($pet->getId(), $pet->getName(), $pet->getSpecies(), $pet->getDescription());
    }
}
