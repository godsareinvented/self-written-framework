<?php

namespace Component\App;

use App\Language\Language;
use Component\Configuration\ConfigurationComponentInterface;
use Component\Di\ServiceContainerBuilderInterface;
use Component\Di\ServiceContainerInterface;
use Component\Logging\LoggingComponent;
use Component\Routing\RoutingComponentInterface;
use Core\Exception\ExceptionBuilder;

/**
 * Пример использования:
 *
 * Создать пользовательский класс App, унаследовавший AppComponent
 *
 * (new App(
 *     new ConfigurationComponent(),
 *     new ServiceContainerBuilder(),
 *     new RoutingComponent()
 * ))
 *     ->initialize()
 *     ->run();
 *
 * Компоненты для приложения можно передавать в любом порядке
 *
 * После прокидывания компонентов последние установятся внутри приложения
 * Их инициализацию необходимо будет прописать в методе AppComponent::initialize
 */
abstract class AppComponent implements AppComponentInterface
{
    protected ServiceContainerInterface $serviceContainer;
    protected readonly ?ConfigurationComponentInterface $configuration;
    protected readonly ?RoutingComponentInterface $router;
    protected readonly ?ServiceContainerBuilderInterface $serviceContainerBuilder;
    protected readonly ?LoggingComponent $logger;

    public function __construct(
        ...$componentList
    ) {
        $this->importComponents($componentList);
    }

    public function getConfiguration(): ?ConfigurationComponentInterface
    {
        return $this->configuration;
    }

    public function getServiceContainer(): ?ServiceContainerInterface
    {
        return $this->serviceContainer;
    }

    public function getLogger(): ?LoggingComponent
    {
        return $this->logger;
    }

    /**
     * @throws \Throwable
     */
    public function run(): void
    {
        if ($this->router === null) {
            ExceptionBuilder::new()
                ->setLanguageMessage('Routing component not found', Language::EN)
                ->setLanguageMessage('Не найден компонент маршрутизации', Language::RU)
                ->throw();
        }

        $this->router->callCallback($this);
    }

    /**
     * todo: В будущем переписать компонент:
     *   Отделить конфигурацию конкретных компоеннтов (роутинг, DI и т.д.) от AppComponent,
     *   т.к. это не является ответственностью последнего.
     *   AppComponent пусть сам инициализирует только заданные компоненты через прописанные вне колбеки(?).
     *   ...Или как-нибудь иначе.
     */
    abstract public function initialize(): self;

    private function importComponents(array $componentList): void
    {
        foreach ($componentList as $component) {
            match (true) {
                $component instanceof RoutingComponentInterface => $this->router = $component,
                $component instanceof ConfigurationComponentInterface => $this->configuration = $component,
                $component instanceof ServiceContainerBuilderInterface => $this->serviceContainerBuilder = $component,
            };
        }
    }
}
