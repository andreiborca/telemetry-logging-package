<?php

namespace App\Factories;

use App\Enums\StringLogFormat;
use App\Interfaces\LoggerDriverFactoryInterface;
use App\Interfaces\LoggerDriverInterface;
use App\LogDrivers\ConsoleLoggerDriver;
use App\LogDrivers\FileLoggerDriver;
use App\LogDrivers\SqlLoggerDriver;
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
			"sql" => $this->initSqlDriver($driverConfiguration),
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

	/**
	 * @param array $driverConfiguration
	 *
	 * @return LoggerDriverInterface
	 *
	 * @throws Exception
	 */
	public function initSqlDriver(array $driverConfiguration): LoggerDriverInterface {
		$missingFields = [];
		$requiredFields = [
			"driver",
			"host",
			"dbname",
			"username",
			"password",
			"charset",
			"table"
		];

		foreach ($requiredFields as $requiredField) {
			if (
				!array_key_exists($requiredField, $driverConfiguration)
				|| empty(trim($driverConfiguration[$requiredField]))
			) {
				$missingFields[] = $requiredField;
			}
		}

		if (!empty($requiredField)) {
			throw new Exception(
				"Missing or empty configuration fields for SQLLog driver. The fields are: ",
				implode(", ", $missingFields)
			);
		}

    	return new SqlLoggerDriver($driverConfiguration);
	}
}