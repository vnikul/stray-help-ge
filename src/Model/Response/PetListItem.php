<?php

declare(strict_types=1);

namespace App\Model\Response;

class PetListItem
{
    private string $id;

    private string $name;

    private string $species;

    private string $description;

    /**
     * @param string $id
     * @param string $name
     * @param string $species
     * @param string $description
     */
    public function __construct(string $id, string $name, string $species, string $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->species = $species;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getId(): string
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

