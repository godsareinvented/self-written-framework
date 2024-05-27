<?php

namespace Core\Exception\ExceptionList;

class RuntimeException extends \RuntimeException implements \Throwable, ExceptionInterface
{
    use ExceptionTrait;
}
