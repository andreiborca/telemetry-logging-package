<?php

namespace Tests\unit\Enums;

use App\Enums\LogLevel;
use App\Exceptions\InvalidLogLevelException;
use PHPUnit\Framework\TestCase;

/**
 * @group log-level
 * @group unit-test
 */
final class LogLevelTest extends TestCase
{
    public function testConstantsValue(): void
    {
        $this->assertEquals("DEBUG",LogLevel::DEBUG);
        $this->assertEquals("INFO",LogLevel::INFO);
        $this->assertEquals("WARNING",LogLevel::WARNING);
        $this->assertEquals("ERROR",LogLevel::ERROR);
        $this->assertEquals("CRITICAL",LogLevel::CRITICAL);
    }

    public function testConstantsValueToInt(): void
    {
        $this->assertEquals(0,LogLevel::toInt(LogLevel::DEBUG));
        $this->assertEquals(1,LogLevel::toInt(LogLevel::INFO));
        $this->assertEquals(2,LogLevel::toInt(LogLevel::WARNING));
        $this->assertEquals(3,LogLevel::toInt(LogLevel::ERROR));
        $this->assertEquals(4,LogLevel::toInt(LogLevel::CRITICAL));
    }

    public function testConstantsValueToIntError(): void
    {
        $this->expectException(InvalidLogLevelException::class);
        LogLevel::toInt("INVALID_LOG_Level");
    }

    public function testSupportedLogLevels(): void {
        $expectedSupportedLogLevels = [
            LogLevel::DEBUG,
            LogLevel::INFO,
            LogLevel::WARNING,
            LogLevel::ERROR,
            LogLevel::CRITICAL,
        ];
        $this->assertEquals($expectedSupportedLogLevels, LogLevel::getSupportedLogLevels());
    }
}
