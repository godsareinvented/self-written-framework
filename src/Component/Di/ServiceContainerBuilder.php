<?php

namespace Component\Di;

use App\Language\Language;
use Component\Configuration\ConfigurationComponent;
use Component\Configuration\ConfigurationComponentInterface;
use Component\Di\Dto\ServiceDefinition;
use Component\Di\Parser\ServiceDefinitionParser;
use Core\Exception\ExceptionBuilder;

/**
 * Класс с ответственностью "Построитель контейнера сервисов"
 *
 * Всегда берёт информацию о конфигурируемых сервисах из ConfigurationComponent, по ключу "services"
 */
class ServiceContainerBuilder implements ServiceContainerBuilderInterface
{
    private array $rawServiceList;
    /**
     * @var ServiceDefinition[]
     */
    private array $serviceDefinitionList;
    /**
     * todo: Реализовать кеширование позже.
     */
    private bool $enableCaching = false;
    private ?ConfigurationComponent $configuration = null;

    public function setConfig(ConfigurationComponentInterface $configuration): ServiceContainerBuilderInterface
    {
        $this->configuration = $configuration;
        return $this;
    }

    public function enableCaching(): self
    {
        $this->enableCaching = true;
        return $this;
    }

    /**
     * todo: Не оптимальный алгоритм (несколько проходов по одному и тому же сервису в моменты инициализации аргументов).
     *
     * @throws \Throwable
     */
    public function build(): ServiceContainer
    {
        $this->throwExceptionIfNoConfig();
        $this->initializeServiceList();

        $serviceContainer = new ServiceContainer();
        $stack = new \SplStack();

        foreach ($this->serviceDefinitionList as $rootServiceDefinition) {
            /**
             * Без рекурсивный импорт сервисов и их аргументов-сервисов.
             */
            $stack[] = $rootServiceDefinition;
            while ($stack->count() > 0) {
                $currentServiceDefinition = $stack->top();

                if ($this->isServiceExistingInServiceContainer(
                    $currentServiceDefinition->getClassName(),
                    $serviceContainer
                )) {
                    $stack->pop();
                    continue;
                }
                $this->validateClassExistence($currentServiceDefinition);

                /**
                 * Генерация сервисов без аргументов
                 */
                if (!$currentServiceDefinition->getRawArguments()) {
                    $serviceContainer->registerService($currentServiceDefinition);
                    $stack->pop();
                    continue;
                }

                /**
                 * Генерация сервисов, обладающих аргументами-сервисами
                 */
                $areArgumentsInitialised = true;
                foreach ($currentServiceDefinition->getRawArguments() as $argument) {
                    if ($this->isServiceExistingInServiceContainer($argument, $serviceContainer)) {
                        $currentServiceDefinition->addArgument($this->serviceDefinitionList[$argument]);
                        continue;
                    }
                    $stack[]                 = $this->serviceDefinitionList[$argument];
                    $areArgumentsInitialised = false;
                }
                if (!$areArgumentsInitialised) {
                    continue;
                }

                $serviceContainer->registerService($currentServiceDefinition);
                $stack->pop();
            }
        }

        unset($this->serviceDefinitionList);

        return $serviceContainer;
    }

    private function initializeServiceList(): void
    {
        $this->rawServiceList = $this->configuration->getProperty('services', []);
        $this->validateServiceConfig();
        $this->convertToServiceDefinitionList();
        unset($this->rawServiceList);
    }

    /**
     * todo: Добавить валидацию, когда будет готов компонент валидации.
     *
     * @return void
     */
    private function validateServiceConfig(): void
    {
    }

    private function convertToServiceDefinitionList(): void
    {
        foreach ($this->rawServiceList as $classNameOrAlias => $serviceData) {
            $serviceDefinition                                               = ServiceDefinitionParser::parse(
                $classNameOrAlias,
                $serviceData
            );
            $this->serviceDefinitionList[$serviceDefinition->getClassName()] = $serviceDefinition;
        }
    }

    /**
     * @throws \Throwable
     */
    private function validateClassExistence(ServiceDefinition $serviceDefinition): void
    {
        if (!\class_exists($serviceDefinition->getClassName())) {
            ExceptionBuilder::new()
                ->setLanguageMessage(
                    "The transferred service does not exist (class={$serviceDefinition->getClassName()})",
                    Language::EN
                )
                ->setLanguageMessage(
                    "Переданный сервис не существует (class={$serviceDefinition->getClassName()})",
                    Language::RU
                )
                ->throw();
        }
    }

    private function isServiceExistingInServiceContainer(string $key, ServiceContainer $serviceContainer): bool
    {
        try {
            return!! $serviceContainer->get($key);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    private function throwExceptionIfNoConfig(): void
    {
        if ($this->configuration === null) {
            ExceptionBuilder::new()
                ->setLanguageMessage('The configuration component must be passed', Language::EN)
                ->setLanguageMessage('Компонент конфигурации должен быть передан', Language::RU)
                ->throw();
        }

        if ($this->configuration->getProperty('services') === null) {
            ExceptionBuilder::new()
                ->setLanguageMessage('No configuration of services', Language::EN)
                ->setLanguageMessage('Отсутствует конфигурация сервисов', Language::RU)
                ->throw();
        }
    }
}

