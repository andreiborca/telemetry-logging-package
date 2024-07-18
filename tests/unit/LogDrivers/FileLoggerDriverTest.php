<?php

namespace Tests\unit\LogDrivers;

use App\DTO\LogEntry;
use App\Enums\LogLevel;
use App\Enums\StringLogFormat;
use App\Interfaces\LogEntryInterface;
use App\LogDrivers\FileLoggerDriver;
use PHPUnit\Framework\TestCase;

/**
 * @group log-file-driver
 * @group log-drivers
 * @group unit-test
 */
class FileLoggerDriverTest extends TestCase
{
    private string $logFilePath;

    protected function setUp(): void
    {
        $this->logFilePath = "./logs/test.txt";

        // Ensure the log file is clean before each test
        if (file_exists($this->logFilePath)) {
            unlink($this->logFilePath);
        }
    }

    protected function tearDown(): void
    {
        // Clean up the log file after each test
        if (file_exists($this->logFilePath)) {
            unlink($this->logFilePath);
        }
    }

    /**
     * @dataProvider logEntryScenarios
     * @param LogEntryInterface $logEntry
     */
    public function testJsonFormat(LogEntryInterface $logEntry): void
    {
        $logDriver = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_JSON,
        );

        $expectedLogEntry = json_encode([
            'timestamp' => $logEntry->getTimestamp(),
            'level' => $logEntry->getLevel(),
            'message' => $logEntry->getMessage(),
            'metadata' => $logEntry->getMetadata(),
        ]);

        $logDriver->log($logEntry);

        $this->assertFileExists($this->logFilePath);
        $this->assertStringEqualsFile($this->logFilePath, $expectedLogEntry . PHP_EOL);
    }

    /**
     * @dataProvider logEntryScenarios
     * @param LogEntryInterface $logEntry
     */
    public function testTextFormat(LogEntryInterface $logEntry): void
    {
        $logDriver = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );

        $formattedMetadata = '';
        if (!empty($logEntry->getMetadata())) {
            foreach ($logEntry->getMetadata() as $key => $value) {
                $formattedMetadata .= "{$key}:{$value};";
            }
        }

        $expectedLogEntry = sprintf(
            "[%s][%s] %s (Metadata: %s)",
            $logEntry->getTimestamp(),
            $logEntry->getLevel(),
            $logEntry->getMessage(),
            $formattedMetadata
        );

        $logDriver->log($logEntry);

        $this->assertFileExists($this->logFilePath);
        $this->assertStringEqualsFile($this->logFilePath, $expectedLogEntry . PHP_EOL);
    }

    public static function logEntryScenarios(): iterable
    {
        return [
            [
                new LogEntry(
                    '2024-07-16 12:34:56',
                    LogLevel::ERROR,
                    "Test error message (1)",
                    [
                        "env" => "testing",
                        "customerId" => "customerId",
                    ],
                ),
            ], [
                new LogEntry(
                    '2024-07-16 12:34:56',
                    LogLevel::DEBUG,
                    "Test error message (2)",
                    [
                        "env" => "testing",
                    ],
                ),
            ], [
                new LogEntry(
                    '2024-07-16 12:34:56',
                    LogLevel::INFO,
                    "Test error message (3)",
                    [],
                ),
            ],
        ];
    }
}