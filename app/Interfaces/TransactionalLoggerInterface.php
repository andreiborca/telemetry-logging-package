<?php

namespace App\Interfaces;

interface TransactionalLoggerInterface extends LoggerInterface
{
    /**
     * @param string $message
     * @param array $metadata
     * @return string
     */
    public function startTransactionLogging(string $message, array $metadata): string;

    /**
     * @param string $message
     * @param array $metadata
     */
    public function updateTransactionLogging(string $message, array $metadata = []): void;

    /**
     * @param string $message
     * @param array $metadata
     */
    public function endTransactionLogging(string $message, array $metadata = []): void;
}