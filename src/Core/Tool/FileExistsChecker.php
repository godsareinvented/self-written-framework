<?php

namespace Core\Tool;

class FileExistsChecker
{
    public const MAIN_DIRECTORY_APP = APPLICATION_DIR;
    public const MAIN_DIRECTORY_SRC = SRC_DIR;
    public const MAIN_DIRECTORY_ROOT = ROOT_DIR;

    public const EXTENSION_PHP = '.php';

    public static function check(
        string $filePathAndName,
        string $mainDirectory = self::MAIN_DIRECTORY_APP,
        string $extension = self::EXTENSION_PHP
    ): bool {
        return \file_exists($mainDirectory . self::getPreparedFileName($extension, $filePathAndName));
    }

    private static function getPreparedFileName(string $filePathAndName, string $extension): string {
        return \str_ends_with($extension, $filePathAndName)
            ? $filePathAndName
            : $filePathAndName . $extension;
    }
}