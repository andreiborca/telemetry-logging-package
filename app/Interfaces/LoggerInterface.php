<?php

namespace App\Interfaces;

interface LoggerInterface
{
    public function setDriver(LoggerDriverInterface $driver): void;
    public function setLogLevel($logLevel): void;
    public function getLogLevel() : string;
    public function log(string $level, string $message, array $metadata = []): void;
    public function debug(string $message, array $metadata = []): void;
    public function info(string $message, array $metadata = []): void;
    public function warning(string $message, array $metadata = []): void;
    public function error(string $message, array $metadata = []): void;
    public function critical(string $message, array $metadata = []): void;
}