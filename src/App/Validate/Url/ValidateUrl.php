<?php

namespace App\Validate\Url;

use App\Validate\Type\ValidateType;
use App\Validate\ValidatorInterface;

class ValidateUrl implements ValidatorInterface
{
    public function __invoke(mixed $url): bool {
        return (new ValidateType())('string', $url) && \parse_url($url);
    }
}