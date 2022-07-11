<?php

declare(strict_types=1);

namespace App\Model\Response;

class PetListItem
{
    private int $id;

    private string $name;

    private string $species;

    private string $description;

    /**
     * @param int $id
     * @param string $name
     * @param string $species
     * @param string $description
     */
    public function __construct(int $id, string $name, string $species, string $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->species = $species;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSpecies(): string
    {
        return $this->species;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}

