<?php

namespace Component\Configuration;

use Component\Configuration\ConfigurationReader\ConfigReaderInterface;

class ConfigurationComponent implements ConfigurationComponentInterface
{
    private array $configStorage = [];
    /**
     * @var ConfigReaderInterface[]
     */
    private array $configReaderList = [];
    private bool $cacheIsEnabled = false;

    public function enableCaching(): ConfigurationComponentInterface
    {
        $this->cacheIsEnabled = true;

        return $this;
    }

    public function use(ConfigReaderInterface $configReader): ConfigurationComponentInterface
    {
        $this->configReaderList[] = $configReader;

        return $this;
    }

    public function initialize(): void
    {
        foreach ($this->configReaderList as $configReader) {
            $this->configStorage = \array_merge_recursive($this->configStorage, $configReader->getConfig());
        }
    }

    public function getRoot(): array
    {
        return $this->configStorage;
    }

    public function getProperty(string $key, mixed $defaultValue = null, bool &$isExists = true): mixed
    {
        try {
            return $this->configStorage[$key];
        } catch (\Throwable) {
            $isExists = false;

            return null;
        }
    }
}
