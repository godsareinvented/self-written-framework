<?php

namespace Component\Logging;

use Component\Configuration\ConfigurationComponent;
use Component\Logging\Handler\WriterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * todo: Переписать на компонент.
 */
class LoggingComponent implements LoggerInterface
{
    /**
     * @var WriterInterface[]
     */
    private array $writerStorage = [];

    public function __construct(
        private readonly ConfigurationComponent $configuration,
        private readonly string $canal = ''
    ) {
    }

    public function use(WriterInterface $writer): LoggingComponent
    {
        $this->writerStorage[] = $writer;

        return $this;
    }

    public function emergency(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $preparedMessage = $this->getPreparedMessage($level, $message, $context);
        foreach ($this->writerStorage as $writer) {
            $writer->write($preparedMessage);
        }
    }

    private function getPreparedMessage($level, \Stringable|string $message, array $context): string
    {
        $dateFormatted = (new \DateTime())->format('Y-m-d H:i:s');
        $contextString = \json_encode($context);

        return \sprintf(
            '[%s] %s%s: %s %s%s',
            $dateFormatted,
            $this->canal . '.' ?: '',
            $level,
            $message,
            $contextString,
            PHP_EOL
        );
    }
}
