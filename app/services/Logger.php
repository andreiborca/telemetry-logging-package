<?php

namespace App\Services;

use App\DTO\LogEntry;
use App\Enums\LogLevel;
use App\Exceptions\InvalidLogLevelException;
use App\Interfaces\LoggerDriverInterface;
use App\Interfaces\LoggerInterface;
use Ramsey\Uuid\Uuid;

class Logger implements LoggerInterface
{
    private LoggerDriverInterface $driver;
    private string $logLevel;
    private int $logLevelSeverity;

    # Transaction logging related properties
    private array $transactionMetadata = [];

    /**
     * Logger constructor.
     * @param LoggerDriverInterface $driver
     * @param string $logLevel
     * @throws InvalidLogLevelException
     */
    public function __construct(LoggerDriverInterface $driver, $logLevel = LogLevel::DEBUG)
    {
        $this->setDriver($driver);
        $this->setLogLevel($logLevel);
    }

    /**
     * @param LoggerDriverInterface $driver
     */
    public function setDriver(LoggerDriverInterface $driver): void
    {
        $this->driver = $driver;
    }

    /**
     * @param $logLevel
     *
     * @throws InvalidLogLevelException
     */
    public function setLogLevel($logLevel): void
    {
        if (!in_array($logLevel, LogLevel::getSupportedLogLevels())) {
            throw new InvalidLogLevelException($logLevel);
        }

        $this->logLevel = $logLevel;
        $this->logLevelSeverity = LogLevel::toInt($logLevel);
    }

    /**
     * @return string
     */
    public function getLogLevel() : string {
        return $this->logLevel;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
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

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
    public function debug(string $message, array $metadata = []): void {
        $this->log(LogLevel::DEBUG, $message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
    public function info(string $message, array $metadata = []): void {
        $this->log(LogLevel::INFO, $message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
    public function warning(string $message, array $metadata = []): void {
        $this->log(LogLevel::WARNING, $message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
    public function error(string $message, array $metadata = []): void {
        $this->log(LogLevel::ERROR, $message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
    public function critical(string $message, array $metadata = []): void {
        $this->log(LogLevel::CRITICAL, $message, $metadata);
    }

    /**
     * All logs created through transaction logging will be created with INFO level.
     * To create logs for transaction use method named `updateTransactionLogging`.
     * To end the transaction logging use method named `endTransactionLogging`
     *
     * @param string $message
     * @param array $metadata The provided metadata information will be added to metadata field for all created logs
     *                        during transactional logging
     *
     * @return string The transaction trace id.
     *
     * @throws InvalidLogLevelException
     */
    public function startTransactionLogging(string $message, array $metadata): string {
        $this->transactionMetadata = $metadata;
        $uuid = Uuid::uuid7();
        $this->transactionMetadata["TraceId"] = $uuid->toString();

        $this->log(LogLevel::INFO, $message, $this->transactionMetadata);

        return $this->transactionMetadata["TraceId"];
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
    public function updateTransactionLogging(string $message, array $metadata = []): void {
        $logMetadata = array_merge($this->transactionMetadata, $metadata);
        $this->log(LogLevel::INFO, $message, $logMetadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws InvalidLogLevelException
     */
    public function endTransactionLogging(string $message, array $metadata = []): void {
        $logMetadata = array_merge($this->transactionMetadata, $metadata);
        $this->log(LogLevel::INFO, $message, $logMetadata);

        // Clear transaction context
        $this->transactionMetadata = [];
    }
}