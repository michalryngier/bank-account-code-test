<?php

namespace App\WalletManagement\Domain;

use Ramsey\Uuid\UuidInterface;
use App\Shared\Domain\Entity\Wallet as SharedWallet;

interface WalletManagementRepositoryInterface
{
    public function find(UuidInterface $id, $lockMode = null, $lockVersion = null): SharedWallet|null;

    /**
     * @return Wallet[]
     */
    public function findAll(): array;

    public function save(SharedWallet $entity, bool $flush = false): void;

    public function remove(SharedWallet $entity, bool $flush = false): void;
}