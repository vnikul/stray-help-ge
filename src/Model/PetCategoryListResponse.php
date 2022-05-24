<?php

declare(strict_types=1);

namespace App\Model;

class PetCategoryListResponse
{
    /** @var PetCategoryListItem[] */
    private array $items;

    /** @param PetCategoryListItem[] */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /** @return  PetCategoryListItem[] */
    public function getItems(): array
    {
        return $this->items;
    }
}
