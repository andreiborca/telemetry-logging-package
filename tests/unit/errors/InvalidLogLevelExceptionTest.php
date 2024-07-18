<?php

namespace Tests\Unit\errors;

use App\Enums\LogLevel;
use App\Errors\InvalidLogLevelException;
use PHPUnit\Framework\TestCase;

/**
 * @group errors
 * @group unit-test
 */
final class InvalidLogLevelExceptionTest extends TestCase
{
    public function testErrorMessage(): void
    {
        $invalidLogLevel = "TEST_LOG_LEVEL";

        $expectedErrMsg = sprintf(
            "Invalid Log Level %s. The support log levels are %s",
            $invalidLogLevel,
            implode(",", LogLevel::getSupportedLogLevels()),
        );

        $error = new InvalidLogLevelException($invalidLogLevel);

        $this->assertEquals($expectedErrMsg, $error->getMessage());
    }
}