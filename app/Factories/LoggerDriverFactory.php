<?php

namespace App\Factories;

use App\Enums\StringLogFormat;
use App\Interfaces\LoggerDriverFactoryInterface;
use App\Interfaces\LoggerDriverInterface;
use App\LogDrivers\ConsoleLoggerDriver;
use App\LogDrivers\FileLoggerDriver;
use Exception;

class LoggerDriverFactory implements LoggerDriverFactoryInterface
{
    /**
     * @param string $driverName
     * @param array $driverConfiguration
     *
     * @return LoggerDriverInterface
     *
     * @throws Exception
     */
    public function initDriver(
        string $driverName,
        array $driverConfiguration
    ): LoggerDriverInterface
    {
        return match ($driverName) {
            "console" => $this->initConsoleDriver($driverConfiguration),
            "file" => $this->initFileDriver($driverConfiguration),
            default => throw new Exception(sprintf(
                "Unsupported logging driver `%s`. Change the value of option `default`.",
                $driverName
            ))
        };
    }

    public function initConsoleDriver(array $driverConfiguration): LoggerDriverInterface {
        $format = $driverConfiguration["format"] ?? StringLogFormat::FORMAT_TEXT;
        return new ConsoleLoggerDriver($format);
    }

    /**
     * @param array $driverConfiguration
     *
     * @return LoggerDriverInterface
     *
     * @throws Exception
     */
    public function initFileDriver(array $driverConfiguration): LoggerDriverInterface {
        if (empty(trim($driverConfiguration["path"]))){
            throw new Exception("Missing log file path for driver file. Please provided under key `path`");
        }

        $path = $driverConfiguration["path"];
        $format = $driverConfiguration["format"] ?? StringLogFormat::FORMAT_TEXT;

        return new FileLoggerDriver($path, $format);
    }
}