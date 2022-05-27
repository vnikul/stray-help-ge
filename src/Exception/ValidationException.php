<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends RuntimeException
{
    public function __construct(private ConstraintViolationList $violations)
    {
        parent::__construct('request didn\'t pass the validation');
    }

    /**
     * @return ConstraintViolationList
     */
    public function getViolations(): ConstraintViolationList
    {
        return $this->violations;
    }
}