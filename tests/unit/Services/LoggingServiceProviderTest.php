<?php


namespace Tests\unit\Services;


use App\Factories\LoggerDriverFactory;
use App\services\LoggingServiceProvider;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @group logging-service-provider
 * @group unit-service-logging-service-provider
 * @group unit-test
 */
class LoggingServiceProviderTest extends TestCase
{
    function testEmptyConfigurationFilePath() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Configuration file path for telemetry logging is empty");

        $factoryMock = \Mockery::mock(LoggerDriverFactory::class);
        new LoggingServiceProvider($factoryMock, "");

        $this->assertFileExists();
    }

    function testCouldNotConfigurationFilePath() {
        $configPath = "telemetry_logging.yml";
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(sprintf(
            "Could not find the configuration file based on provided path `%s`",
            $configPath
        ));

        $factoryMock = \Mockery::mock(LoggerDriverFactory::class);
        new LoggingServiceProvider($factoryMock, $configPath);
    }
}