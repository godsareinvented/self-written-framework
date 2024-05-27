<?php

namespace Component\Tool;

class Http
{
    /**
     * todo: Дополнить оставшимися методами.
     */
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_LIST = [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT];
}
