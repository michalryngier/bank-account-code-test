<?php

namespace App\Reporting\Application\ReportGenerator;

use App\Shared\Domain\Entity\Wallet;
use App\Shared\Domain\Exception\DirectoryNotFoundException;

interface WalletOperationsReportGeneratorInterface
{
    public function __construct(string $reportsDirectory);

    /**
     * @throws DirectoryNotFoundException
     */
    public function generateReport(Wallet $wallet): bool;
}