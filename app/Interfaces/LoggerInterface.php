<?php

namespace App\Interfaces;

interface LoggerInterface
{
    public function setDriver(LoggerDriverInterface $driver): void;
    public function setLogLevel($logLevel): void;
    public function getLogLevel() : string;
    public function log(string $level, string $message, array $metadata = []): void;
}