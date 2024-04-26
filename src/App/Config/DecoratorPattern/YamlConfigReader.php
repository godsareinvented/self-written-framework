<?php

namespace App\Config\DecoratorPattern;

use App\Language\Language;
use Core\Exception\ExceptionBuilder;
use Throwable;

class YamlConfigReader implements ConfigReaderInterface
{
    /**
     * @throws Throwable
     */
    public function getConfig(ConfigReaderInterface $configReader = null, array $options = []): array {
        if (!\array_key_exists('directory', $options)) {
            ExceptionBuilder::new()
                ->setLanguageMessage('The yaml file location directory should be passed to', Language::EN)
                ->setLanguageMessage('Директория расположения yaml-файлов должна быть передана', Language::RU)
                ->throw();
        }

        $this->collateAllYamlConfigFiles($options['directory']);
    }

    private function collateAllYamlConfigFiles(string $directory): array {
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $filename)
        {
            // filter out "." and ".."
            if ($filename->isDir()) {
                continue;
            }

            $this->configStorage[] = $this->getFileContent();
        }
    }

    private function getFileContent(string $filepath): array {

    }
}