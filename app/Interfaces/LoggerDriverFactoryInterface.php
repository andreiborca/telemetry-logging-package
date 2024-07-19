<?php

namespace App\Interfaces;

interface LoggerDriverFactoryInterface
{
    /**
     * @param string $driverName
     * @param array $driverConfiguration
     *
     * @return LoggerDriverInterface
     */
    public function initDriver(string $driverName, array $driverConfiguration): LoggerDriverInterface;
}