<?php

namespace App\Services;

use App\DTO\LogEntry;
use App\Enums\LogLevel;
use App\Errors\InvalidLogLevelError;
use App\Interfaces\LoggerDriverInterface;

class Logger
{
     private LoggerDriverInterface $driver;
     private string $logLevel;
     private int $logLevelSeverity;

    public function __construct(LoggerDriverInterface $driver, $logLevel = LogLevel::DEBUG)
    {
        $this->setDriver($driver);
        $this->setLogLevel($logLevel);
    }

    public function setDriver(LoggerDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function setLogLevel($logLevel)
    {
        if (!in_array($logLevel, LogLevel::getSupportedLogLevels())) {
            throw new InvalidLogLevelError($logLevel);
        }

        $this->logLevel = $logLevel;
        $this->logLevelSeverity = LogLevel::toInt($logLevel);
    }

    public function getLogLevel() : string {
        return $this->logLevel;
    }

    public function log(string $level, string $message, array $metadata = [])
    {
        if (!in_array($level, LogLevel::getSupportedLogLevels())) {
            throw new InvalidLogLevelError($level);
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
}