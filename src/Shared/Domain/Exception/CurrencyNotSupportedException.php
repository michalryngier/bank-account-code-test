<?php

namespace App\Shared\Domain\Exception;

class CurrencyNotSupportedException extends \Exception
{
    /**
     * @throws CurrencyNotSupportedException
     */
    public static function throwWhen(bool $currencyNotSupported, string $currency): void
    {
        if ($currencyNotSupported) {
            throw new self("Currency $currency is not supported.");
        }
    }
}