<?php

namespace App\UserDefined\App;

use App\UserDefined\Configuration\ConfigReader\PhpConfigReader;
use App\UserDefined\Controller\ErrorController;
use App\UserDefined\Controller\MainController;
use App\UserDefined\Controller\TestController;
use Component\App\AppComponent;
use Component\Configuration\ConfigurationReader\YamlConfigReader;
use Component\Routing\RouterConfigurator\RouterConfigurator;
use Component\Tool\Directory;
use Component\Tool\Http;

class App extends AppComponent
{
    /**
     * @throws \Throwable
     */
    public function initialize(): AppComponent
    {
        /**
         * todo: Отделить ответственность  и его настройку компонента.
         *   Пусть компонент содержит только готовые данные (методы).
         *   А настрйока компонента будет происходит через сервис-конфигуратор.
         */
        $this->configuration
            ->use(new PhpConfigReader())
            ->use(new YamlConfigReader(new Directory(YAML_CONFIG_DIR)))
            ->initialize();

        $this->serviceContainer = $this->serviceContainerBuilder
            ->setConfig($this->configuration)
            ->enableCaching()
            ->build();

        $routes = (new RouterConfigurator())
            ->add()
                ->requestUri('/')
                ->controller([MainController::class, 'index'])
            ->end()
            ->add()
                ->requestUri('/test-message')
                ->controller([TestController::class, 'index'])
                ->method(Http::METHOD_GET)
            ->end()
            ->add()
                ->controller([ErrorController::class, 'page404'])
                ->default()
            ->end();
        $this->router->setRoutes($routes);

        return $this;
    }
}
