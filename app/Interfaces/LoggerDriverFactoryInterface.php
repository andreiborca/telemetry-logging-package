<?php

namespace App\Interfaces;

interface LoggerDriverFactoryInterface
{
    public function initDriver(string $driverName, array $driverConfiguration): LoggerDriverInterface;
}