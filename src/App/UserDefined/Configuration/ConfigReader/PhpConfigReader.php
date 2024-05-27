<?php

namespace App\UserDefined\Configuration\ConfigReader;

use Component\Configuration\ConfigurationReader\ConfigReaderInterface;

class PhpConfigReader implements ConfigReaderInterface
{
    public function getConfig(): array
    {
        return [
            'test_value' => \str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),
        ];
    }
}
