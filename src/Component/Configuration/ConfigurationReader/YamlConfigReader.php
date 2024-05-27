<?php

namespace Component\Configuration\ConfigurationReader;

use Component\Tool\Directory;

class YamlConfigReader implements ConfigReaderInterface
{
    use ConfigReaderTrait;

    public function __construct(private readonly Directory $directory)
    {
    }

    /**
     * @throws \Throwable
     */
    public function getConfig(): array
    {
        return $this->collateAllConfigFiles($this->directory, fn($serviceFilePath) => \yaml_parse_file($serviceFilePath)
        );
    }
}
