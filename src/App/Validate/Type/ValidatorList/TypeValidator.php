<?php

namespace App\Validate\Type\ValidatorList;

interface TypeValidator
{
    public function __invoke(mixed $value): bool;
}