<?php


namespace App\Errors;


use Throwable;

class InvalidLogFormatError extends \Error
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