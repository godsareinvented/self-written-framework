<?php

namespace App\Validate\Type\ValidatorList;

class NumberValidate implements TypeValidator
{
    public function __invoke(mixed $value): bool
    {
        return \is_numeric($value);
    }
}
