<?php

namespace Component\Routing\RouterConfigurator;

use App\Language\Language;
use Component\Configuration\ConfigurationComponentInterface;
use Component\Routing\Dto\Route;
use Component\Routing\Service\IsComplexRequestUriCheckerService;
use Component\Tool\Directory;
use Component\Tool\Http;
use Core\Exception\ExceptionBuilder;

/**
 * todo: Поддержка middleware?!?...
 */
class RouterConfigurator implements RouterConfiguratorInterface
{
    private array $resultRouteListOrganizedByMethod = [];
    private ?Route $defaultRoute = null;
    private ?Route $lastRoute = null;

    public function getResult(): array
    {
        return [$this->resultRouteListOrganizedByMethod, $this->defaultRoute];
    }

    /**
     * todo: Импорт из конфига добавить позже.
     *
     * @throws \Throwable
     */
    public function import(ConfigurationComponentInterface $configuration): self
    {
        // ...
        return $this;
    }

    /**
     * todo: Аннотации доабвить позже.
     */
    public function annotations(Directory $controllerDirectory): self
    {
        // ...
        return $this;
    }

    public function add(): self
    {
        $this->lastRoute = new Route();

        return $this;
    }

    public function requestUri(string $requestUri): self
    {
        $this->lastRoute->setRequestUri(\trim($requestUri));

        return $this;
    }

    public function method(string $method): self
    {
        $this->lastRoute->setMethod($method);

        return $this;
    }

    public function controller(callable $callback): self
    {
        $this->lastRoute->setCallback($callback);

        return $this;
    }

    public function action(callable $callback): self
    {
        $this->controller($callback);

        return $this;
    }

    public function default(): self
    {
        $this->lastRoute->setIsDefault(true);

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function end(): self
    {
        if (empty($this->lastRoute)) {
            return $this;
        }

        $this->throwExceptionIfNoArguments();

        if ($this->lastRoute->isDefault()) {
            $this->setDefaultRoute();
        }
        $this->setRouteIsComplexProperty();
        $this->saveRoute();

        return $this;
    }

    /**
     * @throws \Throwable
     */
    private function setDefaultRoute(): void
    {
        $this->throwExceptionIfDefaultRouteAlreadyExists();
        $this->defaultRoute = $this->lastRoute;
    }

    private function setRouteIsComplexProperty(): void
    {
        $isComplex = IsComplexRequestUriCheckerService::check($this->lastRoute->getRequestUri());
        $this->lastRoute->setIsComplex($isComplex);
    }

    private function saveRoute(): void
    {
        $method = $this->lastRoute->getMethod();
        if (null !== $method) {
            $this->addToSpecificMethodList($method);
        } else {
            $this->addToAllMethodLists();
        }
    }

    private function addToSpecificMethodList(string $method): void
    {
        if (!\array_key_exists($method, $this->resultRouteListOrganizedByMethod)) {
            $this->resultRouteListOrganizedByMethod[$method] = [];
        }
        $this->resultRouteListOrganizedByMethod[$method][] = $this->lastRoute;
    }

    private function addToAllMethodLists(): void
    {
        foreach (Http::METHOD_LiST as $method) {
            $this->addToSpecificMethodList($method);
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    private function throwExceptionIfNoArguments(): void
    {
        if (
            (!$this->lastRoute->getRequestUri() &&!$this->lastRoute->isDefault())
            || (!$this->lastRoute->getCallback())
        ) {
            ExceptionBuilder::new()
                ->setLanguageMessage('All route values must be set', Language::EN)
                ->setLanguageMessage('Необходимо установить все значения маршрута', Language::RU)
                ->throw();
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    private function throwExceptionIfDefaultRouteAlreadyExists(): void
    {
        if (null !== $this->defaultRoute) {
            ExceptionBuilder::new()
                ->setLanguageMessage('The default route is already set', Language::EN)
                ->setLanguageMessage('Маршрут по умолчанию уже задан', Language::RU)
                ->throw();
        }
    }
}
