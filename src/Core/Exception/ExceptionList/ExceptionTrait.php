<?php

namespace Core\Exception\ExceptionList;

use App\Language\Language;

trait ExceptionTrait
{
    private array $languageMessages = [];

    public function addMessage(string $message, string $languageLiteral = Language::BASE): void
    {
        $this->languageMessages[$languageLiteral] = $message;
    }

    public function getLanguageMessage(string $languageLiteral = Language::BASE): string|false
    {
        return $this->languageMessages[$languageLiteral] ?? false;
    }

    public function getMessageInAllLanguages(): string
    {
        return \implode(' | ', $this->languageMessages);
    }
}
