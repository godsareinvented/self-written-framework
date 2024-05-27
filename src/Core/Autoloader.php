<?php

namespace Core;

class Autoloader
{
    public static function set(): void
    {
        \spl_autoload_register([self::class, 'callback']);
    }

    private static function callback(string $namespaceAndFileName): void
    {
        $directories = ['src' . DIRECTORY_SEPARATOR];

        foreach ($directories as $directory) {
            $filePath = ROOT_DIR . $directory . $namespaceAndFileName . '.php';
            if (!\file_exists($filePath)) {
                continue;
            }

            require_once $filePath;
        }
    }
}
