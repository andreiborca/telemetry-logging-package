<?php

namespace App\Interfaces;

interface LoggerInterface
{
    /**
     * @param LoggerDriverInterface $driver
     */
    public function setDriver(LoggerDriverInterface $driver): void;

    /**
     * @param $logLevel
     */
    public function setLogLevel($logLevel): void;

    /**
     * @return string
     */
    public function getLogLevel() : string;

    /**
     * @param string $level
     * @param string $message
     * @param array $metadata
     */
    public function log(string $level, string $message, array $metadata = []): void;

    /**
     * @param string $message
     * @param array $metadata
     */
    public function debug(string $message, array $metadata = []): void;

    /**
     * @param string $message
     * @param array $metadata
     */
    public function info(string $message, array $metadata = []): void;

    /**
     * @param string $message
     * @param array $metadata
     */
    public function warning(string $message, array $metadata = []): void;

    /**
     * @param string $message
     * @param array $metadata
     */
    public function error(string $message, array $metadata = []): void;

    /**
     * @param string $message
     * @param array $metadata
     */
    public function critical(string $message, array $metadata = []): void;
}