<?php

namespace App\Interfaces;

interface TransactionalLoggerInterface extends LoggerInterface
{
    public function startTransactionLogging(string $message, array $metadata): string;
    public function updateTransactionLogging(string $message, array $metadata = []): void;
    public function endTransactionLogging(string $message, array $metadata = []): void;
}