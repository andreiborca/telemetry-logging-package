<?php

namespace App\LogDrivers;

use App\Enums\StringLogFormat;
use App\Exceptions\InvalidLogFormatException;
use App\Interfaces\LogEntryInterface;
use App\Interfaces\LoggerDriverInterface;
use PHPUnit\Logging\Exception;

class FileLoggerDriver implements LoggerDriverInterface
{
    private string $filePath;
    private string $format;

    /**
     * FileLoggerDriver constructor.
     *
     * @param string $filePath
     * @param string $format
     *
     * @throws InvalidLogFormatException
     */
    public function __construct(
        string $filePath,
        string $format = StringLogFormat::FORMAT_TEXT,
    ) {
        $filePath = trim($filePath);
        if (empty($filePath)) {
            throw new Exception("Empty path for parameter filePath");
        }

        if (!in_array($format, StringLogFormat::getSupportedLogFormats())) {
            throw new InvalidLogFormatException($format, StringLogFormat::getSupportedLogFormats());
        }

        $this->filePath = $filePath;
        $this->format = $format;
    }

    /**
     * @param LogEntryInterface $logEntry
     *
     * @return mixed|void
     */
    public function log(LogEntryInterface $logEntry)
    {
        $logEntryAsString = match ($this->format) {
            StringLogFormat::FORMAT_JSON => $logEntry->toJson(),
            StringLogFormat::FORMAT_TEXT => $logEntry->toString(),
        };

        // TODO: handle for folder creation
        // TODO: Add error handling
        file_put_contents($this->filePath, $logEntryAsString . PHP_EOL, FILE_APPEND);
    }
}