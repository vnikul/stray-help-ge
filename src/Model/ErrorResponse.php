<?php

declare(strict_types=1);

namespace App\Model;

class ErrorResponse
{

    /**
     * @param mixed|string $message
     * @param mixed|string $details
     */
    public function __construct(private string $message, private mixed $details = null)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /** @return string[] */
    public function getDetails(): array
    {
        return $this->details;
    }
}