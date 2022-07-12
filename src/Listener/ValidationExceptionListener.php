<?php

declare(strict_types=1);

namespace App\Listener;

use App\Exception\ValidationException;
use App\Model\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ValidationExceptionListener
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!($exception instanceof ValidationException)) {
            return;
        }

        $data = $this->serializer->serialize(
            new ErrorResponse($exception->getMessage(), [
                'violations' => $exception->getViolations(),
            ]),
            JsonEncoder::FORMAT
        );

        $event->setResponse(new JsonResponse($data, Response::HTTP_BAD_REQUEST, [], true));
    }
}