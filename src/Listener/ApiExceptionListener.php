<?php

declare(strict_types=1);

namespace App\Listener;

use App\Model\ErrorResponse;
use App\Service\ExceptionHandler\ExceptionMapping;
use App\Service\ExceptionHandler\ExceptionMappingResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiExceptionListener
{
    public function __construct(
        private ExceptionMappingResolver $resolver,
        private LoggerInterface          $logger,
        private SerializerInterface      $serializer)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $settings = $this->resolver->resolve(get_class($exception));

        if (null === $settings) {
            $settings = ExceptionMapping::fromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($settings->isLoggable()) {
            $this->logger->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'previous' => $exception->getPrevious()?->getMessage() ?? '',
                ]
            );
        }

        $message = $settings->isHidden() ? Response::$statusTexts[$settings->getCode()] : $exception->getMessage();

        $data = $this->serializer->serialize(new ErrorResponse($message), JsonEncoder::FORMAT);
        $res = new JsonResponse($data, $settings->getCode(), [], true);
        $event->setResponse($res);
    }
}
