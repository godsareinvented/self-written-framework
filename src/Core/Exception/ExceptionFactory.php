<?php

namespace Core\Exception;

use Core\Exception\ExceptionList\DomainException;
use Core\Exception\ExceptionList\Exception;
use Core\Exception\ExceptionList\ExceptionInterface;
use Core\Exception\ExceptionList\RuntimeException;

class ExceptionFactory
{
    public static function createExceptionByType(string $exceptionType): ExceptionInterface
    {
        return match ($exceptionType) {
            ExceptionBuilder::EXCEPTION_TYPE_RUNTIME_EXCEPTION => new RuntimeException(''),
            ExceptionBuilder::EXCEPTION_TYPE_DOMAIN_EXCEPTION => new DomainException(''),
            default => new Exception('')
        };
    }
}
