<?php

namespace App\Di;

use App\Language\Language;
use Core\Exception\ExceptionBuilder;

class ServiceContainerBuilder
{
    private const MAX_LOOP_ITERATION_COUNT = 1000;

    private int $maxLoopIterationCount;

    private string $serviceFilePath;

    private array $serviceList;

    /**
     * @throws \Throwable
     */
    public function __construct(string $serviceFilePath, int $maxLoopIterationCount = self::MAX_LOOP_ITERATION_COUNT) {
        if (!\file_exists($serviceFilePath)) {
            ExceptionBuilder::new()
                ->setLanguageMessage('Passed configuration file service.yaml does not exist', Language::EN)
                ->setLanguageMessage('Полученный конфигурационный файл service.yaml не существует', Language::RU)
                ->throw();
        }
        $this->serviceFilePath = $serviceFilePath;
        $this->maxLoopIterationCount = $maxLoopIterationCount > 0 ? $maxLoopIterationCount : self::MAX_LOOP_ITERATION_COUNT;

        $this->parseYamlConfig();
    }

    public function build(): ServiceContainer {
        $serviceContainer = new ServiceContainer();
        $stack = new \SplStack();
        $loopIteration = 0;

        $test = $this->wrapInGenerator($this->serviceList['services']);
        foreach ($test as $serviceName => $item) {
            $testA = 1;
            break;
        }


        foreach ($test as $serviceName => $item) {
            $testA = 1;
            break;
        }

        $stack[] = new \Generator();


        $stack[] = [&$this->serviceList['services'], \array_key_first($this->serviceList['services'])];
        /**
         * @var array $node
         */
        [$node, $service] = $stack->pop();
        \reset($node);
        $key = \key($node);
        $value = \current($node);

        while ($loopIteration++ <= $this->maxLoopIterationCount) {

        }

        unset($this->serviceList);
        return $serviceContainer;
    }

    private function parseYamlConfig(): void {
        $this->serviceList = \yaml_parse_file($this->serviceFilePath);
    }

    private function wrapInGenerator(array $array): \Generator {
        foreach ($array as $key => $item) {
            yield $key => $item;
        }
    }
}