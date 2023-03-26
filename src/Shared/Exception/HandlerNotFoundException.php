<?php

namespace App\Shared\Exception;

use Exception;
use Symfony\Config\Framework\ExceptionConfig;

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