<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Enum\Currency;
use App\Shared\Domain\ValueObject\Balance;

interface BalanceFactoryInterface
{
    public function createBalance(Currency $currency): Balance;
}