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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

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

        if ($this->isSecurityException($exception)) {
            return;
        }

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
        $details = [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ];

        $data = $this->serializer->serialize(new ErrorResponse($message, $details), JsonEncoder::FORMAT);
        $res = new JsonResponse($data, $settings->getCode(), [], true);
        $event->setResponse($res);
    }

    private function isSecurityException(Throwable $exception): bool
    {
        return $exception instanceof AuthenticationException || $exception instanceof  AccessDeniedException;
    }
}
