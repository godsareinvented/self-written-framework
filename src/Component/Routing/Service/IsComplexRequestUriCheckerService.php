<?php

namespace Component\Routing\Service;

class IsComplexRequestUriCheckerService
{
    public static function check(?string $requestUri): bool
    {
        return null === $requestUri || \mb_strpos($requestUri, '{') !== false;
    }
}
