<?php

namespace Tests\Unit\errors;

use App\Enums\LogLevel;
use App\Errors\InvalidLogLevelError;
use PHPUnit\Framework\TestCase;

/**
 * @group errors
 * @group unit-test
 */
final class InvalidLogLevelErrorTest extends TestCase
{
    public function testErrorMessage(): void
    {
        $invalidLogLevel = "TEST_LOG_LEVEL";

        $expectedErrMsg = sprintf(
            "Invalid Log Level %s. The support log levels are %s",
            $invalidLogLevel,
            implode(",", LogLevel::getSupportedLogLevels()),
        );

        $error = new InvalidLogLevelError($invalidLogLevel);

        $this->assertEquals($expectedErrMsg, $error->getMessage());
    }
}