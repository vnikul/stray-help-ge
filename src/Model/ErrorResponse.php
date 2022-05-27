<?php

declare(strict_types=1);

namespace App\Model;

class ErrorResponse
{

    /**
     * @param mixed|string $message
     */
    public function __construct(private string $message, private mixed $details = null)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getDetails(): mixed
    {
        return $this->details;
    }
}