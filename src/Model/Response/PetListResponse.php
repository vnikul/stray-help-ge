<?php

declare(strict_types=1);

namespace App\Model\Response;

class PetListResponse
{
    /** @var PetResponse[] */
    private array $items;

    /** @param PetResponse[]  $items */
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
