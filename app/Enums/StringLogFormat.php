<?php

namespace App\Enums;

abstract class StringLogFormat {
    const FORMAT_TEXT = 'text';
    const FORMAT_JSON = 'json';

    /**
     * @return array
     */
    public static function getSupportedLogFormats() : array {
        $reflectionClass = new \ReflectionClass(StringLogFormat::class);
        $constants = $reflectionClass->getConstants();

        $logFormats = [];
        foreach ($constants as $constant => $value) {
            $logFormats[] = $value;
        }

        return $logFormats;
    }
}
