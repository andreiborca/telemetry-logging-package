<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidLogFormatException extends Exception
{
    /**
     * InvalidLogFormatException constructor.
     *
     * @param string $format
     * @param array $supportedFormats
     * @param int $code     *
     * @param Throwable|null $previous
     */
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