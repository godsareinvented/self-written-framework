<?php

namespace App\Validate\Type;

use App\Validate\Type\ValidatorList\TypeValidator;
use Core\Tool\FileExistsChecker;

class ValidatorFactory
{
    public static function getTypeValidator(string $type): TypeValidator|false {
        $namespaceAndName = self::getClassPath($type);
        if (!FileExistsChecker::check($namespaceAndName, FileExistsChecker::MAIN_DIRECTORY_SRC)) {
            return false;
        }

        return new $namespaceAndName;
    }

    private static function getClassPath(string $type): string {
        return 'App/Validate/Type/ValidatorList/' . self::getValidatorFileNameByType($type);
    }

    private static function getValidatorFileNameByType(string $type): string {
        return \ucfirst(\strtolower($type)) . 'Validate.php';
    }
}