<?php

namespace App\Enums;

use App\Errors\InvalidLogLevelError;

abstract class LogLevel
{
    const DEBUG = "DEBUG";
    const INFO = "INFO";
    const WARNING = "WARNING";
    const ERROR = "ERROR";
    const CRITICAL = "CRITICAL";

    public static function getSupportedLogLevels() : array {
        $reflectionClass = new \ReflectionClass(LogLevel::class);
        $constants = $reflectionClass->getConstants();

        $logLevels = [];
        foreach ($constants as $constant => $value) {
            $logLevels[] = $value;
        }

        return $logLevels;
    }

    public static function toInt(string $logLevel) : int {
        $asInt = null;

        return match($logLevel) {
            "DEBUG" => 0,
            "INFO" => 1,
            "WARNING" => 2,
            "ERROR" => 3,
            "CRITICAL" => 4,
            default => throw new InvalidLogLevelError($logLevel),
        };
    }
}