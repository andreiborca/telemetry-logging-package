<?php

namespace Tests\unit\Enums;

use App\Enums\LogLevel;
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



}