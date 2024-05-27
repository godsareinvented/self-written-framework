<?php

namespace Component\Logging\Handler;

interface WriterInterface
{
    public function write(string $message): bool;
}
