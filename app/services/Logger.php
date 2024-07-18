<?php

namespace App\Services;

use App\DTO\LogEntry;
use App\Enums\LogLevel;
use App\Exceptions\InvalidLogLevelException;
use App\Interfaces\LoggerDriverInterface;
use App\Interfaces\LoggerInterface;

class Logger implements LoggerInterface
{
     private LoggerDriverInterface $driver;
     private string $logLevel;
     private int $logLevelSeverity;

    public function __construct(LoggerDriverInterface $driver, $logLevel = LogLevel::DEBUG)
    {
        $this->setDriver($driver);
        $this->setLogLevel($logLevel);
    }

    public function setDriver(LoggerDriverInterface $driver): void
    {
        $this->driver = $driver;
    }

    public function setLogLevel($logLevel): void
    {
        if (!in_array($logLevel, LogLevel::getSupportedLogLevels())) {
            throw new InvalidLogLevelException($logLevel);
        }

        $this->logLevel = $logLevel;
        $this->logLevelSeverity = LogLevel::toInt($logLevel);
    }

    public function getLogLevel() : string {
        return $this->logLevel;
    }

    public function log(string $level, string $message, array $metadata = []): void
    {
        if (!in_array($level, LogLevel::getSupportedLogLevels())) {
            throw new InvalidLogLevelException($level);
        }

        if (LogLevel::toInt($level) < $this->logLevelSeverity) {
            return;
        }

        $logEntry = new LogEntry(
            date('Y-m-d H:i:s'),
            $level,
            $message,
            $metadata,
        );

        $this->driver->log($logEntry);
    }

    public function debug(string $message, array $metadata = []): void {
        $this->log(LogLevel::DEBUG, $message, $metadata);
    }

    public function info(string $message, array $metadata = []): void {
        $this->log(LogLevel::INFO, $message, $metadata);
    }

    public function warning(string $message, array $metadata = []): void {
        $this->log(LogLevel::WARNING, $message, $metadata);
    }

    public function error(string $message, array $metadata = []): void {
        $this->log(LogLevel::ERROR, $message, $metadata);
    }

    public function critical(string $message, array $metadata = []): void {
        $this->log(LogLevel::CRITICAL, $message, $metadata);
    }
}