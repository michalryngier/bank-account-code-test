<?php

namespace App\Reporting\Application\ReportGenerator;

use App\Reporting\Domain\Enum\ReportFormat;
use App\Shared\Domain\Exception\InvalidReportFormatException;

interface WalletOperationsReportGeneratorFactoryInterface
{
    public function __construct(string $reportsDirectory);

    /**
     * @throws InvalidReportFormatException
     */
    public function create(?ReportFormat $format): WalletOperationsReportGeneratorInterface;
}