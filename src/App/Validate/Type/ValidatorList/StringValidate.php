<?php

namespace App\Validate\Type\ValidatorList;

class StringValidate implements TypeValidator
{
    public function __invoke(mixed $value): bool {
        return \is_string($value);
    }
}