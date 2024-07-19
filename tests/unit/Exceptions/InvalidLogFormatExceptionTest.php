<?php

namespace Tests\unit\Exceptions;

use App\Enums\StringLogFormat;
use App\Exceptions\InvalidLogFormatException;
use PHPUnit\Framework\TestCase;

/**
 * @group errors
 * @group unit-test
 */
final class InvalidLogFormatExceptionTest extends TestCase
{
    public function testErrorMessage(): void
    {
        $invalidLofFormat = "TEST_LOG_FORMAT";

        $expectedErrMsg = sprintf(
            "Invalid log format '%s'. The support log formats are: %s",
            $invalidLofFormat,
            implode(",", StringLogFormat::getSupportedLogFormats())
        );

        $error = new InvalidLogFormatException($invalidLofFormat, StringLogFormat::getSupportedLogFormats());

        $this->assertEquals($expectedErrMsg, $error->getMessage());
    }
}