<?php

namespace Component\App;

use Component\Configuration\ConfigurationComponentInterface;
use Component\Di\ServiceContainerInterface;
use Component\Logging\LoggingComponent;

interface AppComponentInterface
{
    public function getConfiguration(): ?ConfigurationComponentInterface;

    public function getServiceContainer(): ?ServiceContainerInterface;

    public function getLogger(): ?LoggingComponent;

    public function initialize(): self;

    public function run(): void;
}
