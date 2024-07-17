<?php

namespace App\Errors;

use App\Enums\LogLevel;

class InvalidLogLevelError extends \Error
{
    public function __construct($invalidLogLevel = "", $code = 0, \Throwable $previous = null)
    {
        $message = sprintf(
            "Invalid Log Level %s. The support log levels are %s",
            $invalidLogLevel,
            implode(",", LogLevel::getSupportedLogLevels())
        );

        parent::__construct($message, $code, $previous);
    }
}