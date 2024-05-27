<?php

namespace Component\Di;

use Component\Configuration\ConfigurationComponentInterface;

interface ServiceContainerBuilderInterface
{
    public function setConfig(ConfigurationComponentInterface $configuration): self;

    public function enableCaching(): self;

    public function build(): ServiceContainer;
}
