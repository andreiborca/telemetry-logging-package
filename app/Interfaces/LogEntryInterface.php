<?php

namespace App\Interfaces;

interface LogEntryInterface
{
    public function getLevel() : string;
    public function getMessage() : string;
    public function getMetadata() : array;
    public function getTimestamp() : string;

    public function toArray() : array;
    public function toJson() : string;
    public function toString() : string;

}