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
	 * @throws \Exception
	 */
    public function log(LogEntryInterface $logEntry)
    {
        $logEntryAsString = match ($this->format) {
            StringLogFormat::FORMAT_JSON => $logEntry->toJson(),
            StringLogFormat::FORMAT_TEXT => $logEntry->toString(),
        };

        $result = file_put_contents($this->filePath, $logEntryAsString . PHP_EOL, FILE_APPEND);
        if (false === $result) {
        	throw new \Exception("Failed to write log entry to file." . json_encode($logEntry));
		}
    }
}