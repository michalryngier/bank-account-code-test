<?php

namespace App\WalletManagement\Domain;

use Ramsey\Uuid\UuidInterface;

interface WalletRepositoryInterface
{
    public function find(UuidInterface $id, $lockMode = null, $lockVersion = null): Wallet|null;

    /**
     * @return Wallet[]
     */
    public function findAll(): array;

    public function save(Wallet $entity, bool $flush = false): void;

    public function remove(Wallet $entity, bool $flush = false): void;
}