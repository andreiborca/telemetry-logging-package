<?php

namespace Tests\unit\LogDrivers;

use App\DTO\LogEntry;
use App\Enums\LogLevel;
use App\Enums\StringLogFormat;
use App\Interfaces\LogEntryInterface;
use App\LogDrivers\ConsoleLoggerDriver;
use PHPUnit\Framework\TestCase;

/**
 * @group log-console-driver
 * @group log-drivers
 * @group unit-test
 */
class ConsoleLoggerDriverTest extends TestCase
{
    /**
     * @dataProvider logEntryScenarios
     * @outputBuffering disabled
     * @param LogEntryInterface $logEntry
     */
    public function testJsonFormat(LogEntryInterface $logEntry): void
    {
        $logDriver = new ConsoleLoggerDriver(
            StringLogFormat::FORMAT_JSON,
        );

        $expectedLogEntry = json_encode([
            'timestamp' => $logEntry->getTimestamp(),
            'level' => $logEntry->getLevel(),
            'message' => $logEntry->getMessage(),
            'metadata' => $logEntry->getMetadata(),
        ]) . PHP_EOL;

        // Capture the console output
        ob_start();
        $logDriver->log($logEntry);
        $actualOutput = ob_get_clean();

        $this->assertSame($actualOutput,$expectedLogEntry);
    }

    /**
     * @dataProvider logEntryScenarios
     * @outputBuffering disabled
     * @param LogEntryInterface $logEntry
     */
    public function testTextFormat(LogEntryInterface $logEntry): void
    {
        $logDriver = new ConsoleLoggerDriver(
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
        ) . PHP_EOL;

        // Capture the console output
        ob_start();
        $logDriver->log($logEntry);
        $output = ob_get_clean();

        $this->assertSame($expectedLogEntry, $output);
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