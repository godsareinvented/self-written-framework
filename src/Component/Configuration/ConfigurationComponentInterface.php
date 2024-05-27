<?php

namespace Component\Configuration;

use Component\Configuration\ConfigurationReader\ConfigReaderInterface;

interface ConfigurationComponentInterface
{
    public function enableCaching(): self;

    public function use(ConfigReaderInterface $configReader): self;

    public function initialize(): void;

    public function getRoot(): array;

    public function getProperty(string $key, mixed $defaultValue = null, bool &$isExists = true): mixed;
}
