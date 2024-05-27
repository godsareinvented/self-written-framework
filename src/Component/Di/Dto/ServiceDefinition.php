<?php

namespace Component\Di\Dto;

class ServiceDefinition
{
    private string $key;
    private string $className;
    private ?string $alias = null;
    /**
     * @var ServiceDefinition[]|null
     */
    private ?array $arguments = null;
    /**
     * @var string[]|null
     */
    private ?array $rawArguments = null;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     */
    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return array|null
     */
    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    /**
     * @param array|null $arguments
     */
    public function setArguments(?array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @param ServiceDefinition $serviceDefinition
     * @return void
     */
    public function addArgument(ServiceDefinition $serviceDefinition): void {
        $this->arguments[] = $serviceDefinition;
    }

    /**
     * @return array|null
     */
    public function getRawArguments(): ?array
    {
        return $this->rawArguments;
    }

    /**
     * @param array|null $rawArguments
     */
    public function setRawArguments(?array $rawArguments): void
    {
        $this->rawArguments = $rawArguments;
    }
}
