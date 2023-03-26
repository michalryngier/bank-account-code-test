<?php

namespace App\WalletManagement\Domain;

use App\Shared\Domain\ValueObject\Balance as SharedBalance;

class Balance extends SharedBalance
{
    public function toString(): string
    {
        return sprintf('%01.2f %s', ($this->getValue() / 100), $this->getCurrency()->name);
    }
}