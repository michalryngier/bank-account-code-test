<?php

namespace App\Shared\Domain\Exception;

use Exception;

class HandlerNotFoundException extends Exception
{
    /**
     * @throws HandlerNotFoundException
     */
    public static function throwWhen(bool $handlerNotFound, string $fqcn): void
    {
        if ($handlerNotFound) {
            throw new self("Handler: $fqcn was not found.");
        }
    }
}