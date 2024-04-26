<?php

namespace Core\Exception\ExceptionList;

class DomainException extends \DomainException implements \Throwable, ExceptionInterface
{
    use ExceptionTrait;
}