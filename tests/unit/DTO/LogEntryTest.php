<?php

namespace Tests\unit\DTO;

use App\DTO\LogEntry;
use PHPUnit\Framework\TestCase;

/**
 * @group dto
 * @group unit-test
 */
class LogEntryTest extends TestCase
{
    public function testPropertiesGetter(): void
    {
        $timestamp = '2024-07-16 12:34:56';
        $logLevel = "ERROR";
        $message = "Test error message";
        $metadata = [
            "env" => "testing",
            "customerId" => "customerId",
        ];

        $logEntry = new LogEntry(
            $timestamp,
            $logLevel,
            $message,
            [
                "env" => "testing",
                "customerId" => "customerId",
            ],
        );

        $this->assertEquals($timestamp, $logEntry->getTimestamp());
        $this->assertEquals($logLevel, $logEntry->getLevel());
        $this->assertEquals($message, $logEntry->getMessage());
        $this->assertEquals($metadata, $logEntry->getMetadata());
    }

    /**
     * @dataProvider logEntryScenarios
     * @param array $logEntryAsArray
     */
    public function testMethodToString(array $logEntryAsArray) : void
    {
        $logEntry = new LogEntry(
            $logEntryAsArray["timestamp"],
            $logEntryAsArray["level"],
            $logEntryAsArray["message"],
            $logEntryAsArray["metadata"],
        );

        $formattedMetadata = '';
        if (!empty($logEntryAsArray["metadata"])) {
            foreach ($logEntryAsArray["metadata"] as $key => $value) {
                $formattedMetadata .= "{$key}:{$value};";
            }
        }

        $expectedLogMsg = sprintf(
            "[%s][%s] %s (Metadata: %s)",
            $logEntryAsArray["timestamp"],
            $logEntryAsArray["level"],
            $logEntryAsArray["message"],
            $formattedMetadata
        );

        $this->assertEquals($expectedLogMsg, $logEntry->toString());
    }

    /**
     * @dataProvider logEntryScenarios
     * @param array $logEntryAsArray
     */
    public function testMethodToJson(array $logEntryAsArray) : void
    {
        $logEntry = new LogEntry(
            $logEntryAsArray["timestamp"],
            $logEntryAsArray["level"],
            $logEntryAsArray["message"],
            $logEntryAsArray["metadata"],
        );

        $expectedLogMsg = json_encode($logEntryAsArray);

        $this->assertEquals($expectedLogMsg, $logEntry->toJson());
    }

    /**
     * @dataProvider logEntryScenarios
     * @param array $logEntryAsArray
     */
    public function testMethodToArray(array $logEntryAsArray) : void
    {
        $logEntry = new LogEntry(
            $logEntryAsArray["timestamp"],
            $logEntryAsArray["level"],
            $logEntryAsArray["message"],
            $logEntryAsArray["metadata"],
        );

        $this->assertEquals($logEntryAsArray, $logEntry->toArray());
    }

    public static function logEntryScenarios(): iterable
    {
        return [
            [
                [
                    "timestamp" => '2024-07-16 12:34:56',
                    "level" => "ERROR",
                    "message" => "Test error message (1)",
                    "metadata" => [
                        "env" => "testing",
                        "customerId" => "customerId",
                    ],
                ],
            ], [
                [
                    "timestamp" => '2024-07-16 12:34:56',
                    "level" => "DEBUG",
                    "message" => "Test error message (2)",
                    "metadata" => [
                        "env" => "testing",
                    ],
                ],
            ], [
                [
                    "timestamp" => '2024-07-16 12:34:56',
                    "level" => "INFO",
                    "message" => "Test error message (3)",
                    "metadata" => [],
                ],
            ],
        ];
    }
}