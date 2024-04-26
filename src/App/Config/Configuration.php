<?php

namespace App\Config;

class Configuration
{
    private array $configStorage;

    public function initialize(string $directory): void {
        $this->collateAllYamlConfigFiles($directory);
    }
}