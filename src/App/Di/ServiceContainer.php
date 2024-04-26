<?php

namespace App\Di;

use App\Dto\DI\ServiceDefinitionDto;

class ServiceContainer
{
    private array $serviceStorage;

    public function registerService(string $arrayKey, ServiceDefinitionDto $serviceDefinition): void {

    }

    public function get(string $serviceName): object {

    }
}