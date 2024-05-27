<?php

namespace Core;

/**
 * todo: В будущем перенести в компонент конфигурации.
 */
class Constant
{
    public static function define(): void
    {
        \define('ROOT_DIR', \dirname(__FILE__, 3) . DIRECTORY_SEPARATOR);
        \define('SRC_DIR', ROOT_DIR . \sprintf('src%s', DIRECTORY_SEPARATOR));
        \define('APPLICATION_DIR', SRC_DIR . \sprintf('App%s', DIRECTORY_SEPARATOR));
        \define('YAML_CONFIG_DIR', ROOT_DIR . \sprintf('config%syaml%s', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR));
    }
}
