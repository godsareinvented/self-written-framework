<?php

namespace App\Route;

use App\Controller\ControllerInterface;
use App\Dto\Route\RouteDto;
use App\Language\Language;
use Core\Exception\ExceptionBuilder;
use Core\Exception\ExceptionList\Exception;
use Core\Tool\Url;
use Throwable;

class Router
{
    private const DEFAULT_ROUTE = 'default';
//    private \WeakMap $routerMap;

    private array $routeMap = [];

    public function __construct() {
//        $this->routerMap = new \WeakMap();
    }

    public function register(string $requestUri, string $controller, string $callableMethod): self {
        $this->registerRoute($requestUri, $controller, $callableMethod);
        return $this;
    }

    public function default(string $controller, string $callableMethod): self {
        $this->registerRoute(self::DEFAULT_ROUTE, $controller, $callableMethod);
        return $this;
    }

    /**
     * @throws Throwable
     */
    public function callController(): void {
        $routeDto = $this->getRouteDtoFromMap(Url::getRequestUri());
        [$controllerObject, $callableMethod] = $this->getControllerDataFromDto($routeDto);

        (new $controllerObject())->$callableMethod();
    }

    private function registerRoute(string $requestUri, string $controller, string $callableMethod): void {
        if (!empty($this->routeMap[$requestUri])) {
            return;
        }

        $dto = new RouteDto();
        $dto->setControllerClassName($controller);
        $dto->setMethod($callableMethod);

        $this->routeMap[$requestUri] = $dto;
    }

    /**
     * @throws Throwable
     */
    private function getRouteDtoFromMap(string $requestUri): RouteDto {
        $routeDto = $this->routeMap[$requestUri]
            ?? $this->routeMap[self::DEFAULT_ROUTE]
            ?? null;

        if (!$routeDto) {
            ExceptionBuilder::new()
                ->setLanguageMessage('Suitable route not found', Language::EN)
                ->setLanguageMessage('Не найден подходящий маршрут', Language::RU)
                ->throw();
        }

        return $routeDto;
    }

    /**
     * @throws Throwable
     */
    private function getControllerDataFromDto(RouteDto $dto): array {
        $controllerClassName = $dto->getControllerClassName();
        if (!\class_exists($controllerClassName)) {
            ExceptionBuilder::new()
                ->setLanguageMessage('Controller class not found', Language::EN)
                ->setLanguageMessage('Класс контроллера не найден', Language::RU)
                ->throw();
        }

        $controller = new $controllerClassName();
        $callableMethod = $dto->getMethod();

        if (!$controller instanceof ControllerInterface) {
            ExceptionBuilder::new()
                ->setLanguageMessage('The controller must be transferred', Language::EN)
                ->setLanguageMessage('Необходимо преедать контроллер', Language::RU)
                ->throw();
        }
        if (!\method_exists($controller, $callableMethod)) {
            ExceptionBuilder::new()
                ->setLanguageMessage("Method {$callableMethod} is not found in controller " . $controller::class, Language::EN)
                ->setLanguageMessage("Метод {$callableMethod} отсутствует в контроллере " . $controller::class, Language::RU)
                ->throw();
        }

        return [$controller, $callableMethod];
    }

    /**
     * @deprecated
     *
     * @param string $requestUri
     * @param callable $callback
     * @return $this
     */
    private function registerOld(string $requestUri, callable $callback): self {
        if ($this->routerMap->offsetExists($callback)) {
            return $this;
        }

        $this->routerMap->offsetSet($callback, $requestUri);
        return $this;
    }

    /**
     * @deprecated
     *
     * @return void
     */
    private function callControllerOld(): void {
        $requestUri = Url::getRequestUri();

        foreach ($this->routerMap as $callback => $routeString) {
            if ($requestUri !== $routeString) {
                continue;
            }

            $callback();
            return;
        }
    }
}