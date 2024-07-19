<?php

namespace App\Interfaces;

interface LogEntryInterface
{
    /**
     * @return string
     */
    public function getLevel() : string;

    /**
     * @return string
     */
    public function getMessage() : string;

    /**
     * @return array
     */
    public function getMetadata() : array;

    /**
     * @return string
     */
    public function getTimestamp() : string;

    /**
     * @return array
     */
    public function toArray() : array;

    /**
     * @return string
     */
    public function toJson() : string;

    /**
     * @return string
     */
    public function toString() : string;

}