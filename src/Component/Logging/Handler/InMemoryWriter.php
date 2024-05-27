<?php

namespace Component\Logging\Handler;

class InMemoryWriter implements WriterInterface
{
    public function write(string $message): bool
    {
        return \error_log($message);
    }
}
