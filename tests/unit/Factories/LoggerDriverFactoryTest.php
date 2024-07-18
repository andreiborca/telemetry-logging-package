<?php

namespace Tests\unit\Factories;

use App\Enums\StringLogFormat;
use App\Factories\LoggerDriverFactory;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @group factory-driver
 * @group factories
 * @group unit-test
 */
class LoggerDriverFactoryTest extends TestCase
{
    public function testUnsupportedDriver() {
        $driverName = "My_AWESOME_DRIVER";

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(sprintf(
            "Unsupported logging driver `%s`. Change the value of option `default`.",
            $driverName
        ));

        $factory = new LoggerDriverFactory();
        $factory->initDriver($driverName, []);
    }

    public function testFileDriverMissingPathError() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Missing log file path for driver file. Please provided under key `path`");

        $factory = new LoggerDriverFactory();
        $factory->initDriver("file", []);
    }
}