<?php

namespace Component\Tool;

/**
 * todo: Дописать позже (File, возврат генератора с файлами, ->parent(), относительные пути и т.д.).
 */
class Directory
{
    public function __construct(private readonly string $directory)
    {
    }

    public function __toString(): string
    {
        return $this->directory;
    }

    public function isExists(): bool
    {
        return true;
    }
}
