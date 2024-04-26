<?php

namespace App\Validate\Type;

use App\Language\Language;
use App\Validate\ValidatorInterface;
use Core\Exception\ExceptionBuilder;
use Throwable;

class ValidateType implements ValidatorInterface
{
    /**
     * @throws Throwable
     */
    public function __invoke(string $type, mixed $value): bool {
        if ('' === $type) {
            ExceptionBuilder::new()
                ->setLanguageMessage('An empty validator type has been transferred', Language::EN)
                ->setLanguageMessage('Передан пустой тип валидатора', Language::RU)
                ->throw();
        }

        $validator = ValidatorFactory::getTypeValidator($type);
        if (!$validator) {
            ExceptionBuilder::new()
                ->setLanguageMessage('No type validator class', Language::EN)
                ->setLanguageMessage('Отсутствует класс валидатора', Language::RU)
                ->throw();
        }

        return $validator($value);
    }
}