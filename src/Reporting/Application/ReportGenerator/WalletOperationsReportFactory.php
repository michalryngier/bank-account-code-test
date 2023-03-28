<?php

namespace App\Reporting\Application\ReportGenerator;

use App\Reporting\Domain\Enum\ReportFormat;
use App\Shared\Domain\Exception\InvalidReportFormatException;

class WalletOperationsReportFactory implements WalletOperationsReportGeneratorFactoryInterface
{
    public function __construct(private readonly string $reportsDirectory)
    {
    }

    /**
     * @throws InvalidReportFormatException
     */
    public function create(?ReportFormat $format): WalletOperationsReportGeneratorInterface
    {
        return match ($format) {
            ReportFormat::CSV => new WalletOperationsCSVReportGenerator($this->reportsDirectory),
            default => InvalidReportFormatException::throwWith($format)
        };
    }
}