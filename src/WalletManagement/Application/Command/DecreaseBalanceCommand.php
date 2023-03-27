<?php

namespace App\WalletManagement\Application\Command;

use Ramsey\Uuid\UuidInterface;
use App\Shared\Application\CommandInterface;

final class DecreaseBalanceCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly int $amount = 0
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}