<?php

namespace Core\Exception\ExceptionList;

use App\Language\Language;

class Exception extends \Exception implements \Throwable, ExceptionInterface
{
    use ExceptionTrait;
}