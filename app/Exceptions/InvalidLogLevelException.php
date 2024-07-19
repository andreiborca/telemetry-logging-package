<?php

namespace App\Exceptions;

use App\Enums\LogLevel;
use Exception;

class InvalidLogLevelException extends Exception
{
    /**
     * InvalidLogLevelException constructor.
     *
     * @param string $invalidLogLevel
     * @param int $code
     * @param \Throwable|null $previous
     */
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