<?php

namespace Tests\unit\errors;

use App\Enums\StringLogFormat;
use App\Errors\InvalidLogLevelError;
use PHPUnit\Framework\TestCase;

/**
 * @group errors
 * @group unit-test
 */
final class InvalidLogFormatErrorTest extends TestCase
{
    public function testErrorMessage(): void
    {
        $invalidLofFormat = "TEST_LOG_FORMAT";

        $expectedErrMsg = sprintf(
            "Invalid log format '%s'. The support log formats are: %s",
            $invalidLofFormat,
            StringLogFormat::getSupportedLogFormats()
        );

        $error = new InvalidLogLevelError($invalidLofFormat);

        $this->assertEquals($expectedErrMsg, $error->getMessage());
    }
}