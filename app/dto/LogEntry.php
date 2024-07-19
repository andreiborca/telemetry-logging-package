<?php

namespace App\DTO;

use App\Interfaces\LogEntryInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class LogEntry
 *
 * @package App\DTO
 */
class LogEntry implements LogEntryInterface
{
    /**
     * @var string
     */
    private string $timestamp;

    /**
     * @var string
     */
    private string $level;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var array
     */
    private array $metadata;

    /**
     * LogEntry constructor.
     *
     * @param string $timestamp
     * @param string $level
     * @param string $message
     * @param array $metadata
     */
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

    /**
     * @return string
     */
    public function getLevel() : string
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode([
            'timestamp' => $this->timestamp,
            'level' => $this->level,
            'message' => $this->message,
            'metadata' => $this->metadata,
        ]);
    }

    /**
     * @return array
     *
     * @ArrayShape(['timestamp' => "string", 'level' => "string", 'message' => "string", 'metadata' => "array"])
     */
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