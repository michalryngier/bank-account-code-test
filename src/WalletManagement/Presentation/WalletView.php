<?php

namespace App\WalletManagement\Presentation;

use Ramsey\Uuid\UuidInterface;
use App\Shared\Domain\ValueObject\Balance\Balance as SharedBalance;

class WalletView
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly string $name,
        private readonly SharedBalance $balance
    ) {
    }

    public function showWalletBalance(): array
    {
        return ['balance' => $this->balance->toString()];
    }

    public function showWalletId(): array
    {
        return ['id' => $this->id];
    }
}