<?php

namespace Core\Exception\ExceptionList;

class Exception extends \Exception implements \Throwable, ExceptionInterface
{
    use ExceptionTrait;
}
