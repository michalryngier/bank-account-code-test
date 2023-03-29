<?php

namespace App\Shared\Domain\Exception;

use Exception;

class InvalidReportFormatException extends Exception
{
    /**
     * @throws InvalidReportFormatException
     */
    public static function throwWith(?string $format): void
    {
        $format ??= 'null';
        throw new self("Format: $format is invalid.");
    }
}