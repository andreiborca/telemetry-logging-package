<?php

namespace Tests\unit\Services;

use App\Enums\LogLevel;
use App\Errors\InvalidLogLevelException;
use App\LogDrivers\FileLoggerDriver;
use App\Services\Logger;
use PHPUnit\Framework\TestCase;

/**
 * @group service-logger
 * @group unit-service-logger
 * @group unit-test
 */
class LoggerTest extends TestCase
{
    public function testConstructor(): void {
        $fileDriveMock = \Mockery::mock(FileLoggerDriver::class);

        $this->expectException(InvalidLogLevelException::class);
        new Logger($fileDriveMock, "INVALID_LOG_LEVEL");
    }

    public function testSetLogger(): void {
        $fileDriveMock = \Mockery::mock(FileLoggerDriver::class);
        $loggerService = new Logger($fileDriveMock);

        $this->expectException(InvalidLogLevelException::class);
        $loggerService->setLogLevel("INVALID_LOG_LEVEL");
    }

    public function testGetLogger(): void {
        $fileDriveMock = \Mockery::mock(FileLoggerDriver::class);
        $loggerService = new Logger($fileDriveMock);

        $this->assertEquals(LogLevel::DEBUG, $loggerService->getLogLevel());

        $loggerService->setLogLevel(LogLevel::INFO);
        $this->assertEquals(LogLevel::INFO, $loggerService->getLogLevel());
    }

    public function testLog(): void {
        $fileDriveMock = \Mockery::mock(FileLoggerDriver::class);
        $loggerService = new Logger($fileDriveMock);

        $this->expectException(InvalidLogLevelException::class);
        $loggerService->log(
            "INVALID_LOG_LEVEL",
            "Test error message",
            [],
        );
    }
}