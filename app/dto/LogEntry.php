<?php

namespace App\DTO;

use App\Interfaces\LogEntryInterface;

class LogEntry implements LogEntryInterface
{
    private string $timestamp;
    private string $level;
    private string $message;
    private array $metadata;

    public function __construct(
        string $timestamp,
        string $level,
        string $message,
        array $metadata = [],
    ) {
        $this->timestamp = $timestamp;
        $this->level = $level;
        $this->message = $message;
        $this->metadata = $metadata;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getLevel() : string
    {
        return $this->level;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function getMetadata() : array
    {
        return $this->metadata;
    }

    public function toString() : string
    {
        $formattedMetadata = '';
        if (!empty($this->metadata)) {
            foreach ($this->metadata as $key => $value) {
                $formattedMetadata .= "{$key}:{$value};";
            }
        }

        return sprintf(
            "[%s][%s] %s (Metadata: %s)",
            $this->timestamp,
            $this->level,
            $this->message,
            $formattedMetadata
        );
    }

    public function toJson(): string
    {
        return json_encode([
            'timestamp' => $this->timestamp,
            'level' => $this->level,
            'message' => $this->message,
            'metadata' => $this->metadata,
        ]);
    }

    public function toArray() : array
    {
        return [
            'timestamp' => $this->timestamp,
            'level' => $this->level,
            'message' => $this->message,
            'metadata' => $this->metadata,
        ];
    }
}