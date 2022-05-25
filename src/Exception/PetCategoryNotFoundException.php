<?php

namespace App\Exception;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use RuntimeException;

class PetCategoryNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('category does not exists');
    }
}