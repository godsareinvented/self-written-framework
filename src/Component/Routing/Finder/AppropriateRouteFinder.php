<?php

namespace Component\Routing\Finder;

use Component\Routing\Dto\Route;

class AppropriateRouteFinder
{
    /**
     * todo: Когда будет готов класс Request, заменить аргументы $requestUri и $method на него.
     *
     * @param string $requestUri
     * @param string $method
     * @param array $routeMapOrganizedByMethod
     * @param Route|null $defaultRoute
     *
     * @return Route|null
     */
    public function findMatch(
        string $requestUri,
        string $method,
        array $routeMapOrganizedByMethod,
        ?Route $defaultRoute
    ): ?Route {
        /**
         * @var Route $route
         */
        foreach ($routeMapOrganizedByMethod[$method] as $route) {
            if ($route->isDefault() ||!$this->matchingCheck($requestUri, $route)) {
                continue;
            }

            return $route;
        }

        return $defaultRoute;
    }

    private function matchingCheck(string $requestUri, Route $route): bool
    {
        if (!$route->isComplex()) {
            return $route->getRequestUri() === $requestUri;
        }

        $quotedRouteRequestUri = \preg_quote($route->getRequestUri(), '/');
        $regexRouteUriPattern  = '/' . $this->getConvertedRoutePatternToRegEx($quotedRouteRequestUri) . '/';
        \preg_match_all($regexRouteUriPattern, $requestUri, $matches);

        /**
         * todo: Проверять корректнее, по количеству параметров. В обще их выделить в отдельный класс.
         */
        return !empty($matches[0]);
    }

    /**
     * Конвертирует подстроку параметра URI (.../{ID}/...) в регулярное выражение (..../(?<ID>.+)/...) для поиска параметра в URI запроса.
     *
     * todo: Идея: задавать не просто именованный параметр в URI, но и создать класс, содержащий заранее прописанный regEx паттерн для конкретного параметра.
     *   Например: URI - "/post/13412", URI паттерн - "/post/{ID:Number}", regEx паттерн - "/\/post\/(?<ID>\d{0,16})/".
     *   Пользовательские классы прокидывать через RouteConfigurator::requestUri(), вторым параметром.
     *
     * @param string $requestUriPattern
     *
     * @return string
     */
    private function getConvertedRoutePatternToRegEx(string $requestUriPattern): string
    {
        return \preg_replace('/\\\{\s*([a-zA-Z_0-9]+)\s*\\\}/', '(?<$1>.+)', $requestUriPattern);
    }
}
