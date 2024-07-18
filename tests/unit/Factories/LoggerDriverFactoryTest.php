<?php

namespace Tests\unit\Factories;

use App\Factories\LoggerDriverFactory;
use App\LogDrivers\ConsoleLoggerDriver;
use App\LogDrivers\FileLoggerDriver;
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

    public function testInitConsoleLoggerDriver() {
        $factory = new LoggerDriverFactory();
        $driver = $factory->initDriver("console", []);

        $this->assertEquals(ConsoleLoggerDriver::class, get_class($driver));
    }

    public function testInitFileLoggerDriver() {
        $factory = new LoggerDriverFactory();
        $driver = $factory->initDriver("file", ["path" => "config/telemetry_logging.yml"]);

        $this->assertEquals(FileLoggerDriver::class, get_class($driver));
    }
}