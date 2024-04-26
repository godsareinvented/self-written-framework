<?php

namespace App\Config\DecoratorPattern;

interface ConfigReaderInterface
{
    public function getConfig(ConfigReaderInterface $configReader = null, array $options = []): array;
}