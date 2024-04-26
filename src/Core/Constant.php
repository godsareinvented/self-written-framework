<?php

namespace Core;

class Constant
{
    public static function define(): void {
        \define('ROOT_DIR', \dirname(__FILE__, 3) . '/');
        \define('SRC_DIR', ROOT_DIR . 'src/');
        \define('APPLICATION_DIR', SRC_DIR . 'App/');
        \define('YAML_CONFIG_DIR', APPLICATION_DIR . 'Config/yaml/');
    }
}