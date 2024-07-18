<?php

namespace App\Errors;

use Exception;
use Throwable;

class InvalidLogFormatException extends Exception
{
    public function __construct(
        string $format = "",
        array $supportedFormats,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = sprintf(
            "Invalid log format '%s'. The support log formats are: %s",
            $format,
            implode(",", $supportedFormats)

        );

        parent::__construct($message, $code, $previous);
    }
}