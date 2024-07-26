<?php

namespace App\services;

use App\Interfaces\LoggerDriverFactoryInterface;
use App\Interfaces\LoggerInterface;
use App\Interfaces\TransactionalLoggerInterface;
use Exception;
use Symfony\Component\Yaml\Yaml;

class LoggingServiceProvider
{
    private array $config;
    private LoggerDriverFactoryInterface $driverFactory;
    private LoggerInterface | TransactionalLoggerInterface $logger;

    /**
     * LoggingServiceProvider constructor.
     *
     * @param LoggerDriverFactoryInterface $driverFactory
     * @param string $configPath
     *
     * @throws Exception
     */
    public function __construct(
        LoggerDriverFactoryInterface $driverFactory,
        string $configPath = "config/telemetry_logging.yml",
    ) {
        if (empty(trim($configPath))) {
            throw new Exception("Configuration file path for telemetry logging is empty");
        }

        if (!file_exists($configPath)) {
            throw new Exception(sprintf(
                "Could not find the configuration file based on provided path `%s`",
                $configPath
            ));
        }

        $this->config = Yaml::parseFile($configPath);
        $this->driverFactory = $driverFactory;

        $this->initializeLogger();
    }

    private function initializeLogger() {
        $defaultDriver = $this->config['default'];
        $driversConfig = $this->config['drivers'];

        // TODO: add validation of configuration that configuration for the
        // mentioned driver under default key exists under drivers key

        $driver = $this->driverFactory->initDriver($defaultDriver, $driversConfig[$defaultDriver]);

        $this->logger = new Logger($driver);
    }

    public function getLogger(): LoggerInterface | TransactionalLoggerInterface {
        return $this->logger;
    }
}