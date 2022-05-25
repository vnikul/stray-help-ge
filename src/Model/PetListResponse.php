<?php

declare(strict_types=1);

namespace App\Model;

class PetListResponse
{
    /** @var PetListItem[] */
    private array $items;

    /** @param PetListItem[] */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /** @return  PetListItem[] */
    public function getItems(): array
    {
        return $this->items;
    }
}
