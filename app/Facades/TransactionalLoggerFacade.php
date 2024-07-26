<?php

namespace App\Facades;

use App\Factories\LoggerDriverFactory;
use App\Interfaces\TransactionalLoggerInterface;
use App\services\LoggingServiceProvider;
use Exception;

class TransactionalLoggerFacade
{
    private static TransactionalLoggerInterface $logger;

    /**
     * @throws Exception
     */
    private static function initLogger(): void {
        $driverFactory = new LoggerDriverFactory();
        $loggingServiceProvider = new LoggingServiceProvider(
            $driverFactory,
        );

        self::$logger = $loggingServiceProvider->getLogger();
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public static function log(string $level, string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->log($level, $message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public static function debug(string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->debug($message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public static function info(string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->info($message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public static function warning(string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->warning($message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public static function error(string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->error($message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public static function critical(string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->critical($message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @return string
     *
     * @throws Exception
     */
    public function startTransactionLogging(string $message, array $metadata): string {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->startTransactionLogging($message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public function updateTransactionLogging(string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->updateTransactionLogging($message, $metadata);
    }

    /**
     * @param string $message
     * @param array $metadata
     *
     * @throws Exception
     */
    public function endTransactionLogging(string $message, array $metadata = []): void {
        if (!self::$logger) {
            self::initLogger();
        }
        self::$logger->endTransactionLogging($message, $metadata);
    }

}