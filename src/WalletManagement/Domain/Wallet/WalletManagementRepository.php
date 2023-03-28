<?php

namespace App\WalletManagement\Domain\Wallet;

use App\Shared\Domain\Entity\Wallet as SharedWallet;
use App\Shared\Domain\Repository\WalletRepository as SharedRepository;

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
