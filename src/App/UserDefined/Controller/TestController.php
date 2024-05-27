<?php

namespace App\UserDefined\Controller;

use Component\App\AppComponentInterface;
use Component\Controller\ControllerComponent;

class TestController extends ControllerComponent
{
    /**
     * todo: Временно статический метод.
     */
    public static function index(AppComponentInterface $app): void
    {
        echo 'This is test message!';
    }
}
