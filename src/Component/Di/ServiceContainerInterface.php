<?php

namespace Component\Di;

use Component\Di\Dto\ServiceDefinition;

interface ServiceContainerInterface
{
    public function registerService(ServiceDefinition $serviceDefinition): void;

    public function get(string $serviceClassNameOrAlias): object;
}
