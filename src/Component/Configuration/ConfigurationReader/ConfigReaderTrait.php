<?php

namespace Component\Configuration\ConfigurationReader;

trait ConfigReaderTrait
{
    private function collateAllConfigFiles(string $directory, callable $getParsedContent): array
    {
        $configStorage = [];
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $filename) {
            /**
             * filter out "." and ".."
             */
            if ($filename->isDir()) {
                continue;
            }

            $parsedConfigFile = $getParsedContent($filename->getPathname());
            $configStorage    = \array_merge_recursive($configStorage, $parsedConfigFile);
        }

        return $configStorage;
    }
}
