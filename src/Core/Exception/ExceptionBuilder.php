<?php

namespace Core\Exception;

use App\Language\Language;
use Core\Exception\ExceptionList\ExceptionInterface;

/**
 * todo: Будет переписан на принятие кодов текстовых констант. Чтобы убрать громоздкость.
 */
class ExceptionBuilder
{
    public const EXCEPTION_TYPE_EXCEPTION = 'exception';
    public const EXCEPTION_TYPE_RUNTIME_EXCEPTION = 'runtime_exception';
    public const EXCEPTION_TYPE_DOMAIN_EXCEPTION = 'domain_exception';

    private ExceptionInterface $exception;

    public function __construct(string $exceptionType)
    {
        $this->exception = ExceptionFactory::createExceptionByType($exceptionType);
    }

    public static function new(string $exceptionType = self::EXCEPTION_TYPE_DOMAIN_EXCEPTION): ExceptionBuilder
    {
        return new ExceptionBuilder($exceptionType);
    }

    public function setLanguageMessage(string $message, string $languageLiteral = Language::BASE): self
    {
        $this->exception->addMessage($message, $languageLiteral);

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function throw(): void
    {
        throw $this->exception;
    }
}
