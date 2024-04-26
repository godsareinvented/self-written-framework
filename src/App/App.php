<?php

namespace App;

use App\Controller\StartController;
use App\Controller\TestController;
use App\Di\ServiceContainerBuilder;
use App\Route\Router;
use Throwable;

class App
{
    /** todo: Вынести наружу (роутер и прочие модули же могут инициализироваться по-отдельности, независимо) */
    private Router $router;

    private ServiceContainerBuilder $serviceContainerBuilder;

    /**
     * @throws Throwable
     */
    public function __construct() {
        $this->router = new Router();
        $this->serviceContainerBuilder = new ServiceContainerBuilder(YAML_CONFIG_DIR . 'services.yaml');
    }

    /**
     * @throws Throwable
     */
    public function run(): void {
        $this->router->callController();
    }

    public function initialize(): self {
        $this->serviceContainerBuilder->build();

        /** todo: Переписать на аннотации */
        $this->router
            ->register('/', StartController::class, 'mainPage')
            ->register('/test', TestController::class, 'test')
            ->default(StartController::class, 'mainPage');

        return $this;
    }
}