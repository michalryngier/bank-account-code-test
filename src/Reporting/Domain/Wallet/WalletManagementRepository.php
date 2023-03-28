<?php

namespace App\Reporting\Domain\Wallet;

use App\Shared\Domain\Entity\Wallet as SharedWallet;
use App\Shared\Domain\Repository\WalletRepository;

class WalletManagementRepository extends WalletRepository implements WalletReportRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null): ?SharedWallet
    {
        return parent::find($id, $lockMode, $lockVersion);
    }
}
