<?php


namespace App\Interfaces;


interface LoggerDriverInterface
{
    public function log(LogEntryInterface $logEntry);
}