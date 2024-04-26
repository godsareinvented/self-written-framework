<?php

use App\App;
use Core\Autoloader;
use Core\Constant;
use Core\Exception\ExceptionList\ExceptionInterface;

try {
    require_once '../src/Core/Constant.php';
    require_once '../src/Core/Autoloader.php';

    Constant::define();
    Autoloader::set();

    (new App())
        ->initialize()
        ->run();

} catch (\Throwable $t) {
    throw new \RuntimeException($t instanceof ExceptionInterface
        ? $t->getMessageInAllLanguages()
        : $t->getMessage());
}