<?php

namespace App\WalletManagement\Application\Command;

use Ramsey\Uuid\UuidInterface;
use App\WalletManagement\Domain\Balance;
use App\Shared\Application\CommandInterface;

class CreateWalletCommand implements CommandInterface
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly string $name,
        private readonly Balance $balance
    ) {
    }

    /**
     * @return string UUID
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBalance(): Balance
    {
        return $this->balance;
    }
}