<?php

namespace Component\Routing\Configuration\Parser;

use Component\Routing\Dto\RouteDefinition;

/**
 * todo: Будет использоваться при парсинге конфагурации маршрутов.
 */
class RouteParser
{
    public static function parse(array $routeData): RouteDefinition
    {
        $serviceDefinition = new RouteDefinition();
        [$requestURI, $callbackString, $isDefault] = self::getParsedRouteData($routeData);

        $serviceDefinition->setRequestURI($requestURI);
        $serviceDefinition->setCallbackString($callbackString);
        $serviceDefinition->setIsDefault($isDefault);

        return $serviceDefinition;
    }

    private static function getParsedRouteData(array $routeData): array
    {
        if (\array_key_exists('default', $routeData)) {
            return ['/', $routeData['default'], true];
        }

        return [$routeData['request_uri'], $routeData['callable'], false];
    }
}
