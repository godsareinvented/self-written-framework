<?php

namespace Core\Tool;

use App\Validate\Url\ValidateUrl;

class Url
{
    public static function getRequestUri(string $inputUrl = null): string|false {
        if (!$inputUrl) {
            return self::getCurrentRequestUri();
        }
        if (!(new ValidateUrl())($inputUrl)) {
            return false;
        }

        return \parse_url($inputUrl, \PHP_URL_PATH);
    }

    private static function getCurrentRequestUri(): string {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getCurrentUrl(): string {
        return "$_SERVER[SERVER_PROTOCOL]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}