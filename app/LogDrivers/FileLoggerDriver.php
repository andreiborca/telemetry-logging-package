<?php

namespace App\LogDrivers;

use App\Enums\StringLogFormat;
use App\Errors\InvalidLogFormatError;
use App\Interfaces\LogEntryInterface;
use App\Interfaces\LoggerDriverInterface;
use PHPUnit\Logging\Exception;

class FileLoggerDriver implements LoggerDriverInterface
{
    private string $filePath;
    private string $format;

    public function __construct(
        string $filePath,
        string $logFormat = StringLogFormat::FORMAT_TEXT,
    ) {
        $filePath = trim($filePath);
        if (empty($filePath)) {
            throw new Exception("Empty path for parameter filePath");
        }

        if (!in_array($logFormat, StringLogFormat::getSupportedLogFormats())) {
            throw new InvalidLogFormatError($logFormat, StringLogFormat::getSupportedLogFormats());
        }

        $this->filePath = $filePath;
        $this->format = $logFormat;
    }

    public function log(LogEntryInterface $logEntry)
    {
        $logEntryAsString = match ($this->format) {
            StringLogFormat::FORMAT_JSON => $logEntry->toJson(),
            StringLogFormat::FORMAT_TEXT => $logEntry->toString(),
        };

        file_put_contents($this->filePath, $logEntryAsString . PHP_EOL, FILE_APPEND);
    }
}