<?php

namespace Core\Exception\ExceptionList;

use App\Language\Language;

interface ExceptionInterface
{
    public function addMessage(string $message, string $languageLiteral = Language::BASE): void;

    public function getLanguageMessage(string $languageLiteral = Language::BASE): string|false;

    public function getMessageInAllLanguages(): string;
}