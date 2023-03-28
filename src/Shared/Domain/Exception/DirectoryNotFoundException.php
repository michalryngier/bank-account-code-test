<?php

namespace App\Shared\Domain\Exception;

use Exception;

class DirectoryNotFoundException extends Exception
{
    /**
     * @throws DirectoryNotFoundException
     */
    public static function throwWhen(bool $directoryNotFound, string $directory): void
    {
        if ($directoryNotFound) {
            throw new self("Directory $directory does not exist.");
        }
    }
}