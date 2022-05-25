<?php

declare(strict_types=1);

namespace App\Service\ExceptionHandler;

use http\Exception\InvalidArgumentException;

class ExceptionMappingResolver
{
    private array $mappings;

    public function __construct(array $mappings)
    {
        foreach ($mappings as $class => $mapping) {
            if (!$mapping['code']) {
                throw new InvalidArgumentException('code field is required for class ' . $class);
            }

            $this->addMapping(
                $class,
                $mapping['code'],
                $mapping['hidden'] ?? true,
                $mapping['loggable'] ?? false);
        }
    }

    private function addMapping(string $class, int $code, bool $hidden, bool $loggable): void
    {
        $this->mappings[$class] = new ExceptionMapping($code, $hidden, $loggable);
    }

    public function resolve(string $throwableClass)
    {
        $foundMapping = null;

        foreach ($this->mappings as $class => $settings) {
            if ($throwableClass === $class || is_subclass_of($throwableClass, $class)) {
                $foundMapping = $settings;
                break;
            }
        }

        return $foundMapping;
    }
}