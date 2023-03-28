<?php

namespace App\WalletManagement\Domain\Balance;

use App\Shared\Domain\Enum\Currency;
use App\Shared\Domain\ValueObject\Balance;
use App\Shared\Domain\ValueObject\BalanceFactoryInterface;

class BalanceFactory implements BalanceFactoryInterface
{
    public function createBalance(Currency $currency): Balance
    {
        return match ($currency) {
            Currency::PLN => new Balance(0, Currency::PLN),
            Currency::EUR => new Balance(0, Currency::EUR),
        };
    }
}