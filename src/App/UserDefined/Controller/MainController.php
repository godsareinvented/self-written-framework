<?php

namespace App\UserDefined\Controller;

use Component\App\AppComponentInterface;
use Component\Controller\ControllerComponent;

class MainController extends ControllerComponent
{
    /**
     * todo: Временно статический метод.
     */
    public static function index(AppComponentInterface $app): void
    {
//        echo $this->app->getConfiguration()->getProperty('test_value');
        echo 'Just the main page';
    }
}
