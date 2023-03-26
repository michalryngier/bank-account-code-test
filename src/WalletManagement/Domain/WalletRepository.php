<?php

namespace App\WalletManagement\Domain;

use App\Shared\Domain\Repository\WalletRepository as SharedRepository;

class WalletRepository extends SharedRepository implements WalletRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null): ?Wallet
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
