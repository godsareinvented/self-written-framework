<?php

namespace Component\Routing;

use Component\App\AppComponentInterface;
use Component\Routing\RouterConfigurator\RouterConfiguratorInterface;

interface RoutingComponentInterface
{
    public function setRoutes(RouterConfiguratorInterface $routes): void;

    public function callCallback(AppComponentInterface $app): void;
}
