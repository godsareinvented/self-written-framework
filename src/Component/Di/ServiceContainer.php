<?php

namespace Component\Di;

use App\Language\Language;
use Component\Di\Dto\ServiceDefinition;
use Core\Exception\ExceptionBuilder;

class ServiceContainer implements ServiceContainerInterface
{
    private array $serviceStorage;

    /**
     * @param ServiceDefinition $serviceDefinition
     *
     * @return void
     * @throws \Throwable
     */
    public function registerService(ServiceDefinition $serviceDefinition): void
    {
        $classname = $serviceDefinition->getClassName();
        $arguments = $this->getServiceArguments($serviceDefinition);

        $serviceObject = new $classname(...$arguments);
        $this->serviceStorage[$this->getKey($serviceDefinition)] = $serviceObject;
        if ($serviceDefinition->getAlias()) {
            $this->serviceStorage[$serviceDefinition->getAlias()] = $serviceObject;
        }
    }

    /**
     * @param string $serviceClassNameOrAlias
     *
     * @return object
     * @throws \Throwable
     */
    public function get(string $serviceClassNameOrAlias): object
    {
        if (!\array_key_exists($serviceClassNameOrAlias, $this->serviceStorage)) {
            ExceptionBuilder::new()
                ->setLanguageMessage(
                    "The service is not registered in the Service container (classname={$serviceClassNameOrAlias})",
                    Language::EN
                )
                ->setLanguageMessage(
                    "Сервис с данным именем не зарегистрирован в Service container'е (classname={$serviceClassNameOrAlias})",
                    Language::RU
                )
                ->throw();
        }

        return $this->serviceStorage[$serviceClassNameOrAlias];
    }

    private function getKey(ServiceDefinition $serviceDefinition): string
    {
        return $serviceDefinition->getClassName();
    }

    /**
     * @param ServiceDefinition $serviceDefinition
     *
     * @return array
     * @throws \Throwable
     */
    private function getServiceArguments(ServiceDefinition $serviceDefinition): array
    {
        try {
            return \array_map(
                fn(ServiceDefinition $argument) => $this->get($argument->getClassName()),
                $serviceDefinition->getArguments() ?? []
            );
        } catch (\Throwable) {
            ExceptionBuilder::new()
                ->setLanguageMessage(
                    "The service passed to the constructor must be registered in the Service container 
                    (service classname={$serviceDefinition->getClassName()}, argument service classname={$argument->getClassName()})",
                    Language::EN
                )
                ->setLanguageMessage(
                    "Сервис, передаваемый в конструктор, должен быть зарегистрирован в Service container'е 
                    (service classname={$serviceDefinition->getClassName()}, argument service classname={$argument->getClassName()})",
                    Language::RU
                )
                ->throw();
        }
    }
}
