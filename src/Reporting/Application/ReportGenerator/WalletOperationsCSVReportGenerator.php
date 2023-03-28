<?php

namespace App\Reporting\Application\ReportGenerator;

use App\Shared\Domain\Entity\Wallet;
use App\Shared\Domain\Entity\Operation;
use App\Shared\Domain\Exception\DirectoryNotFoundException;

final class WalletOperationsCSVReportGenerator implements WalletOperationsReportGeneratorInterface
{
    public function __construct(private readonly string $reportsDirectory)
    {
    }

    /**
     * @throws DirectoryNotFoundException
     */
    public function generateReport(Wallet $wallet): bool
    {
        $operations = $wallet->getOperations();
        $fhandler = $this->getFileHandler($wallet);

        if ($fhandler === false) {
            return false;
        }

        foreach ($operations as $operation) {
            /* @var $operation Operation */
            $operationData = $operation->getOpeationData();
            $line = [
                $operation->getId()->toString(),
                $operation->getType()->value,
                $operationData->getBalanceBefore()->getValue(),
                $operationData->getBalanceAfter()->getValue(),
                $operationData->getBalanceBefore()->getCurrency()->value,
                $operationData->getBalanceAfter()->getCurrency()->value,
                $operationData->getBalanceAfter()->hasDifferentValue($operationData->getBalanceBefore()) ? '1' : '0',
                $operationData->getBalanceAfter()->hasDifferentCurrency($operationData->getBalanceBefore()) ? '1': '0',
                $operationData->getBalanceAfter()->getValueDiff($operationData->getBalanceBefore()),
                $operation->getCreatedAt()->format('m.d.Y H:i:s'),
            ];
            fputcsv($fhandler, $line);
        }

        fclose($fhandler);

        return true;
    }

    /**
     * @throws DirectoryNotFoundException
     */
    private function getFileHandler(Wallet $wallet): mixed
    {
        $fileName = $this->createFileName($wallet->getId()->toString());

        $directoryDoesNotExist = is_dir($this->reportsDirectory) === false;
        DirectoryNotFoundException::throwWhen($directoryDoesNotExist, $this->reportsDirectory);

        $handler = fopen("$this->reportsDirectory/$fileName", 'x');
        fputcsv($handler, $this->getReportHeaders());

        return $handler;
    }

    private function createFileName(string $id): string
    {
        return $id . '_' . date('Y-m-d_H-i-s') . '.csv';
    }

    private function getReportHeaders(): array
    {
        return [
            'OPERATION ID',
            'TYPE',
            'BALANCE BEFORE',
            'BALANCE AFTER',
            'CURRENCY BEFORE',
            'CURRENCY AFTER',
            'BALANCE CHANGED',
            'CURRENCY CHANGED',
            'BALANCE DIFF',
            'DATE'
        ];
    }
}