<?php

namespace App\WalletManagement\Domain;

use App\Shared\Domain\Repository\WalletRepository as SharedRepository;
use App\Shared\Domain\Entity\Wallet as SharedWallet;

class WalletManagementRepository extends SharedRepository implements WalletManagementRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null): ?SharedWallet
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
