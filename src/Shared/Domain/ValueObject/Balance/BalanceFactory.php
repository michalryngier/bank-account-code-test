<?php

namespace App\Shared\Domain\ValueObject\Balance;

use App\Shared\Domain\Enum\Currency;

class BalanceFactory
{
    public function __construct(private readonly Currency $currency)
    {
    }

    public function createBalance(): Balance
    {
        return match ($this->currency) {
            Currency::PLN => new Balance(0, Currency::PLN),
            Currency::EUR => new Balance(0, Currency::EUR),
        };
    }
}