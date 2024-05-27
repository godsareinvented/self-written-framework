<?php

namespace Component\Logging\Handler;

class FileWriter implements WriterInterface
{
    /**
     * @throws \Throwable
     */
    public function __construct(private readonly string $filepath)
    {
    }

    public function write(string $message): bool
    {
        return \file_put_contents($this->filepath, $message, FILE_APPEND);
    }
}
