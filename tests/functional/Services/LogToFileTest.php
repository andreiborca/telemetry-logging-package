<?php

namespace Tests\functional\Services;

use App\Enums\LogLevel;
use App\Enums\StringLogFormat;
use App\LogDrivers\FileLoggerDriver;
use App\Services\Logger;
use PHPUnit\Framework\TestCase;

/**
 * @group service-logger
 * @group functional-service-logger
 * @group functional-test
 */
class LogToFileTest extends TestCase
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

    function testLogMethodLowerLogLevel(): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );
        $loggerService = new Logger($fileDrive, LogLevel::WARNING);

        $loggerService->log(
            LogLevel::DEBUG,
            "Test message for lower log level",
            [],
        );

        $this->assertFileDoesNotExist($this->logFilePath);
    }

    /**
     * @dataProvider logEntryForLogLevelMethods
     * @param array $logEntry
     */
    function testDebugMethod(array $logEntry): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );
        $loggerService = new Logger($fileDrive);

        $loggerService->debug(
            $logEntry["message"],
            $logEntry["metadata"],
        );

        $expectedLogEntry = sprintf(
            "[%s] %s (Metadata: %s)",
            LogLevel::DEBUG,
            $logEntry["message"],
            '',
        );

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString(
            $expectedLogEntry,
            $logFileContent,
        );
    }

    /**
     * @dataProvider logEntryForLogLevelMethods
     * @param array $logEntry
     */
    function testInfoMethod(array $logEntry): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );
        $loggerService = new Logger($fileDrive);

        $loggerService->info(
            $logEntry["message"],
            $logEntry["metadata"],
        );

        $expectedLogEntry = sprintf(
            "[%s] %s (Metadata: %s)",
            LogLevel::INFO,
            $logEntry["message"],
            '',
        );

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString(
            $expectedLogEntry,
            $logFileContent,
        );
    }

    /**
     * @dataProvider logEntryForLogLevelMethods
     * @param array $logEntry
     */
    function testWarningMethod(array $logEntry): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );
        $loggerService = new Logger($fileDrive);

        $loggerService->warning(
            $logEntry["message"],
            $logEntry["metadata"],
        );

        $expectedLogEntry = sprintf(
            "[%s] %s (Metadata: %s)",
            LogLevel::WARNING,
            $logEntry["message"],
            '',
        );

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString(
            $expectedLogEntry,
            $logFileContent,
        );
    }

    /**
     * @dataProvider logEntryForLogLevelMethods
     * @param array $logEntry
     */
    function testErrorMethod(array $logEntry): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );
        $loggerService = new Logger($fileDrive);

        $loggerService->error(
            $logEntry["message"],
            $logEntry["metadata"],
        );

        $expectedLogEntry = sprintf(
            "[%s] %s (Metadata: %s)",
            LogLevel::ERROR,
            $logEntry["message"],
            '',
        );

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString(
            $expectedLogEntry,
            $logFileContent,
        );
    }

    /**
     * @dataProvider logEntryForLogLevelMethods
     * @param array $logEntry
     */
    function testCriticalMethod(array $logEntry): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );
        $loggerService = new Logger($fileDrive);

        $loggerService->critical(
            $logEntry["message"],
            $logEntry["metadata"],
        );

        $expectedLogEntry = sprintf(
            "[%s] %s (Metadata: %s)",
            LogLevel::CRITICAL,
            $logEntry["message"],
            '',
        );

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString(
            $expectedLogEntry,
            $logFileContent,
        );
    }


    /**
     * @dataProvider logEntryScenarios
     * @param array $logEntry
     */
    function testTextLogMethodSuccess(array $logEntry): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_TEXT,
        );
        $loggerService = new Logger($fileDrive);

        $loggerService->log(
            $logEntry["level"],
            $logEntry["message"],
            $logEntry["metadata"],
        );

        $formattedMetadata = '';
        if (!empty($logEntry["metadata"])) {
            foreach ($logEntry["metadata"] as $key => $value) {
                $formattedMetadata .= "{$key}:{$value};";
            }
        }
        $expectedLogEntry = sprintf(
            "[%s] %s (Metadata: %s)",
            $logEntry["level"],
            $logEntry["message"],
            $formattedMetadata
        );

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString(
            $expectedLogEntry,
            $logFileContent,
        );
    }

    /**
     * @dataProvider logEntryScenarios
     * @param array $logEntry
     */
    function testJSONtLogMethodSuccess(array $logEntry): void {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_JSON,
        );
        $loggerService = new Logger($fileDrive);

        $loggerService->log(
            $logEntry["level"],
            $logEntry["message"],
            $logEntry["metadata"],
        );

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        foreach ($logEntry as $fieldName => $value) {
            if ("metadata" === $fieldName) {
                $value = json_encode($value);
            }

            $this->assertStringContainsString($fieldName, $logFileContent);
            $this->assertStringContainsString($value, $logFileContent);
        }
    }

    public function testTransactionalLogging() {
        $fileDrive = new FileLoggerDriver(
            $this->logFilePath,
            StringLogFormat::FORMAT_JSON,
        );
        $loggerService = new Logger($fileDrive);

        $transactionMetadata = [
            "isEnabled" => true,
        ];
        $traceId = $loggerService->startTransactionLogging(
            "Start transaction logging",
            $transactionMetadata,
        );

        $logEntries = [
            [
                "message" => "Log Transaction message (1)",
                "metadata" => [
                    "logIndex" => 1,
                ]
            ],
            [
                "message" => "Log Transaction message (2)",
                "metadata" => [
                    "logIndex" => 2,
                ]
            ],
            [
                "message" => "Log Transaction message (3)",
                "metadata" => [
                    "logIndex" => 3,
                ]
            ]

        ];

        foreach ($logEntries as $logEntry) {
            $loggerService->updateTransactionLogging(
                $logEntry["message"],
                $logEntry["metadata"],
            );
        }

        $loggerService->endTransactionLogging(
            "End transaction logging",
            [
                "isEnabled" => false,
            ],
        );

        $transactionMetadata["TraceId"] = $traceId;

        $this->assertFileExists($this->logFilePath);
        $logFileContent = file_get_contents($this->logFilePath);
        foreach ($logEntry as $fieldName => $value) {
            if ("metadata" === $fieldName) {
                $value = array_merge($transactionMetadata, $value);
                $value = json_encode($value);
            }

            $this->assertStringContainsString($value, $logFileContent);
        }

        $this->assertStringContainsString("Start transaction logging", $logFileContent);
        $this->assertStringContainsString(json_encode($transactionMetadata), $logFileContent);

        $transactionMetadata["isEnabled"] = false;
        $this->assertStringContainsString("End transaction logging", $logFileContent);
        $this->assertStringContainsString(json_encode($transactionMetadata), $logFileContent);

        $occurrences = substr_count($logFileContent, $traceId);
        $this->assertEquals(5, $occurrences);

        $occurrences = substr_count($logFileContent, "INFO");
        $this->assertEquals(5, $occurrences);
    }

    public static function logEntryScenarios(): iterable
    {
        return [
            [
                [
                    "level" => "ERROR",
                    "message" => "Test error message (1)",
                    "metadata" => [
                        "env" => "testing",
                        "customerId" => "customerId",
                    ],
                ],
            ], [
                [
                    "level" => "DEBUG",
                    "message" => "Test error message (2)",
                    "metadata" => [
                        "env" => "testing",
                    ],
                ],
            ], [
                [
                    "level" => "INFO",
                    "message" => "Test error message (3)",
                    "metadata" => [],
                ],
            ],
        ];
    }

    public static function logEntryForLogLevelMethods(): iterable
    {
        return [
            [
                [
                    "message" => "Test log level method",
                    "metadata" => [],
                ],
            ],
        ];
    }
}