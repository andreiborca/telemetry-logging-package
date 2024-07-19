<?php

namespace App\Interfaces;

interface LoggerDriverInterface
{
    /**
     * @param LogEntryInterface $logEntry
     *
     * @return mixed
     */
    public function log(LogEntryInterface $logEntry);
}