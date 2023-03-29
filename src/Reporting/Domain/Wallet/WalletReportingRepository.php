<?php

namespace App\Reporting\Domain\Wallet;

use App\Shared\Domain\Entity\Wallet as SharedWallet;
use App\Shared\Domain\Repository\WalletRepository;

class WalletReportingRepository extends WalletRepository implements WalletReportingRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null): ?SharedWallet
    {
        return parent::find($id, $lockMode, $lockVersion);
    }
}
