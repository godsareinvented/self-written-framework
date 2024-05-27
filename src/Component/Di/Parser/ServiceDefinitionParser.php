<?php

namespace Component\Di\Parser;

use Component\Di\Dto\ServiceDefinition;

class ServiceDefinitionParser
{
    /**
     * @param string $key
     * @param array|null $serviceData
     *
     * @return ServiceDefinition
     */
    public static function parse(string $key, ?array $serviceData): ServiceDefinition
    {
        $serviceDefinition = new ServiceDefinition();
        [$className, $alias, $arguments] = self::getParsedServiceData($key, $serviceData);

        $serviceDefinition->setKey($key);
        $serviceDefinition->setClassName($className);
        $serviceDefinition->setAlias($alias);
        $serviceDefinition->setRawArguments($arguments);

        return $serviceDefinition;
    }

    /**
     * @param string $className
     * @param array|null $serviceData
     *
     * @return array
     */
    private static function getParsedServiceData(string $className, ?array $serviceData): array
    {
        $arguments = $serviceData['arguments'] ?? null;

        if (\class_exists($className)) {
            $resultClassName = $className;
            $resultAlias     = $serviceData['alias'] ?? null;

            return [$resultClassName, $resultAlias, $arguments];
        }

        $resultClassName = $serviceData['class'];
        $resultAlias     = $className;

        return [$resultClassName, $resultAlias, $arguments];
    }
}
