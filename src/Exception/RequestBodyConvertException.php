<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class RequestBodyConvertException extends RuntimeException
{
    public function __construct(Throwable $exception)
    {
        parent::__construct('json is invalid, can not unmarshall', 0, $exception);
    }
}