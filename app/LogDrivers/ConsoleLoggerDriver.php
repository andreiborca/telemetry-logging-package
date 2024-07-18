<?php


namespace App\LogDrivers;


use App\Enums\StringLogFormat;
use App\Errors\InvalidLogFormatException;
use App\Interfaces\LogEntryInterface;
use App\Interfaces\LoggerDriverInterface;

class ConsoleLoggerDriver implements LoggerDriverInterface
{
    private string $format;

    public function __construct(
        string $logFormat = StringLogFormat::FORMAT_TEXT,
    ) {
        if (!in_array($logFormat, StringLogFormat::getSupportedLogFormats())) {
            throw new InvalidLogFormatException($logFormat, StringLogFormat::getSupportedLogFormats());
        }

        $this->format = $logFormat;
    }

    public function log(LogEntryInterface $logEntry)
    {
        $logEntryAsString = match ($this->format) {
            StringLogFormat::FORMAT_JSON => $logEntry->toJson(),
            StringLogFormat::FORMAT_TEXT => $logEntry->toString(),
        };


        echo $logEntryAsString . PHP_EOL;
    }

}