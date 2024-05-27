<?php

namespace Component\Routing\Dto;

class Route
{
    /**
     * Паттерн URI
     *
     * Может быть null, если маршрут является маршрутом по умолчанию
     */
    private ?string $requestUri = null;
    /**
     * Требуемый метод HTTP (get/post/...)
     *
     * Если не задан, считается, что подходит любой глагол запроса
     */
    private ?string $method = null;
    /**
     * todo: Есть какой-то интерфейс для указания колбека как типа?..
     *
     * Коллбек, вызываемый, если URI соответствует паттерну маршрута
     */
    private $callback;
    /**
     * Флаг, является ли маршрутом по умолчанию. Маршрут будет использоваться, если не будет найден ни один подходящий маршрут
     */
    private bool $isDefault = false;
    /**
     * Флаг, является ли паттерн URI сложным/комплексным (т.е. содержащим параметры. Например: "/post/{ID}" - "/post/13412/". См. "ЧПУ")
     */
    private bool $isComplex;

    /**
     * @return string|null
     */
    public function getRequestUri(): ?string
    {
        return $this->requestUri;
    }

    /**
     * @param string|null $requestUri
     */
    public function setRequestUri(?string $requestUri): void
    {
        $this->requestUri = $requestUri;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     */
    public function setMethod(?string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     */
    public function setCallback(callable $callback): void
    {
        $this->callback = $callback;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * @param bool $isDefault
     */
    public function setIsDefault(bool $isDefault): void
    {
        $this->isDefault = $isDefault;
    }

    /**
     * @return bool
     */
    public function isComplex(): bool
    {
        return $this->isComplex;
    }

    /**
     * @param bool $isComplex
     */
    public function setIsComplex(bool $isComplex): void
    {
        $this->isComplex = $isComplex;
    }
}
