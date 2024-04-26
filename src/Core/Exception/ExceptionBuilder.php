<?php

namespace Core\Exception;

use App\Language\Language;
use Core\Exception\ExceptionList\ExceptionInterface;
use Throwable;

class ExceptionBuilder
{
    public const EXCEPTION_TYPE_EXCEPTION = 'exception';
    public const EXCEPTION_TYPE_RUNTIME_EXCEPTION = 'runtime_exception';
    public const EXCEPTION_TYPE_DOMAIN_EXCEPTION = 'domain_exception';

    private ExceptionInterface $exception;

    public function __construct(string $exceptionType, string $messageOnBaseLanguage)
    {
        $this->exception = ExceptionFactory::createExceptionByType($exceptionType);
        if ($messageOnBaseLanguage) {
            $this->exception->addMessage($messageOnBaseLanguage, Language::BASE);
        }
    }

    public static function new(string $exceptionType = self::EXCEPTION_TYPE_DOMAIN_EXCEPTION, string $message = null): ExceptionBuilder {
        return new ExceptionBuilder($exceptionType, $message);
    }

    public function setLanguageMessage(string $message, string $languageLiteral = Language::BASE): self {
        $this->exception->addMessage($message, $languageLiteral);
        return $this;
    }

    /**
     * @throws Throwable
     */
    public function throw(): void {
        throw $this->exception;
    }
}