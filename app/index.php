<?php

use App\UserDefined\App\App;
use Component\Configuration\ConfigurationComponent;
use Component\Di\ServiceContainerBuilder;
use Core\Autoloader;
use Core\Constant;
use Core\Exception\ExceptionList\ExceptionInterface;
use Component\Routing\RoutingComponent;

try {
    require_once '../vendor/autoload.php';
    require_once '../src/Core/Constant.php';
    require_once '../src/Core/Autoloader.php';

    Constant::define();
    Autoloader::set();

    (new App(
        new ConfigurationComponent(),
        new ServiceContainerBuilder(),
        new RoutingComponent()
    ))
        ->initialize()
        ->run();
} catch (\Throwable $t) {
    throw new \RuntimeException(
        $t instanceof ExceptionInterface
            ? $t->getMessageInAllLanguages()
            : $t->getMessage()
    );
}