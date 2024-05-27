<?php

namespace Component\Routing;

use App\Language\Language;
use Component\App\AppComponentInterface;
use Component\Routing\RouterConfigurator\RouterConfiguratorInterface;
use Component\Routing\Dto\Route;
use Component\Routing\Finder\AppropriateRouteFinder;
use Core\Exception\ExceptionBuilder;

/**
 * todo: Добавить поддержку кеширования, когда компонент кеширования будет готов.
 */
class RoutingComponent implements RoutingComponentInterface
{
    private array $routeMapOrganizedByMethod = [];
    private ?Route $defaultRoute;
    private AppropriateRouteFinder $appropriateRouteFinder;

    public function __construct()
    {
        $this->appropriateRouteFinder = new AppropriateRouteFinder();
    }

    public function setRoutes(RouterConfiguratorInterface $routes): void
    {
        /**
         * todo: Необходимо добавить валидатор списка комплексных маршрутов на уникальность
         *   (при конвертации в регулярку паттерны могут иметь одинаковый вид при разных именованных группах)
         */
        [$this->routeMapOrganizedByMethod, $this->defaultRoute] = $routes->getResult();
    }

    /**
     * @throws \Throwable
     */
    public function callCallback(AppComponentInterface $app): void
    {
        $appropriateRoute = $this->appropriateRouteFinder->findMatch(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            $this->routeMapOrganizedByMethod,
            $this->defaultRoute
        );
        $this->throwExceptionIfNoRoute($appropriateRoute);
        ($appropriateRoute->getCallback())($app/** todo: Передавать Request, параметры */);
        /**
         * todo: Кто будет заниматься обработкой Response'а?.. Явно не роутер. Не его ответственность.
         */
    }

    /**
     * @param Route|null $appropriateRoute
     *
     * @return void
     * @throws \Throwable
     */
    private function throwExceptionIfNoRoute(?Route $appropriateRoute): void
    {
        if (null === $appropriateRoute) {
            ExceptionBuilder::new()
                ->setLanguageMessage('No router matching the URI was found', Language::EN)
                ->setLanguageMessage('Не обнаружен роутер, подходящий под URI', Language::RU)
                ->throw();
        }
    }
}
