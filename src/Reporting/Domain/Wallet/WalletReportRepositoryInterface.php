<?php

namespace App\Reporting\Domain\Wallet;

use Ramsey\Uuid\UuidInterface;
use App\Shared\Domain\Entity\Wallet as SharedWallet;

interface WalletReportRepositoryInterface
{
    public function find(UuidInterface $id, $lockMode = null, $lockVersion = null): SharedWallet|null;
}