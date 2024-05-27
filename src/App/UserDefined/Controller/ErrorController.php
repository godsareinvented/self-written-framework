<?php

namespace App\UserDefined\Controller;

use Component\App\AppComponentInterface;
use Component\Controller\ControllerComponent;

class ErrorController extends ControllerComponent
{
    /**
     * todo: Временно статический метод.
     */
    public static function page404(AppComponentInterface $app): void
    {
        echo 'Fail! 404.';
    }
}
