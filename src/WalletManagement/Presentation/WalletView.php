<?php

namespace App\WalletManagement\Presentation;

use Ramsey\Uuid\UuidInterface;
use App\WalletManagement\Domain\Balance;

class WalletView
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly string $name,
        private readonly Balance $balance
    ) {
    }

    public function showWalletBalance(): array
    {
        return [
            'balance' => $this->balance->toString(),
        ];
    }
}