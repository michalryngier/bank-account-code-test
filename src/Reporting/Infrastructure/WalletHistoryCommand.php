<?php

namespace App\Reporting\Infrastructure;

use Exception;
use Ramsey\Uuid\Uuid;
use App\Reporting\Domain\Enum\ReportFormat;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Shared\Domain\Exception\WalletNotFoundException;
use App\Shared\Domain\Exception\DirectoryNotFoundException;
use App\Shared\Domain\Exception\InvalidReportFormatException;
use App\Reporting\Domain\Wallet\WalletReportingRepositoryInterface;
use App\Reporting\Application\ReportGenerator\WalletOperationsReportGeneratorFactoryInterface;
use Ramsey\Uuid\Exception\InvalidUuidStringException;

#[AsCommand(
    name: 'app:wallet:history',
    description: 'A command that generates operations history report for specified wallet in a chosen format.'
)]
class WalletHistoryCommand extends Command
{
    public function __construct(
        private readonly WalletReportingRepositoryInterface $walletRepository,
        private readonly WalletOperationsReportGeneratorFactoryInterface $reportGeneratorFactory
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('wallet-id', InputArgument::REQUIRED, 'Wallet ID')
            ->addArgument('format', InputArgument::REQUIRED, 'Report file format');
    }

    /**
     * @throws WalletNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $errorMessage = "An error occurred during report generation: {message}";

        try {
            $walletId = Uuid::fromString($input->getArgument('wallet-id'));
            $wallet = $this->walletRepository->find($walletId);
        } catch (InvalidUuidStringException $e) {
            $io->error(str_replace(['{message}'], $e->getMessage(), $errorMessage));

            return Command::FAILURE;
        }

        WalletNotFoundException::throwWhen(is_null($wallet), $walletId);

        $reportFormat = ReportFormat::tryFrom(strtolower($input->getArgument('format')));

        try {
            $reportGenerator = $this->reportGeneratorFactory->create($reportFormat);
        } catch (InvalidReportFormatException $e) {
            $io->error(str_replace(['{message}'], $e->getMessage(), $errorMessage));

            return Command::FAILURE;
        }

        try {
            $reportGenerated = $reportGenerator->generateReport($wallet);
        } catch (DirectoryNotFoundException $e) {
            $io->error(str_replace(['{message}'], $e->getMessage(), $errorMessage));

            return Command::FAILURE;
        }

        if ($reportGenerated === false) {
            $io->error(str_replace(['{message}'], 'a report generation failed.', $errorMessage));

            return Command::FAILURE;
        }

        $io->success("Report for {$wallet->getId()} has been generated.");

        return Command::SUCCESS;
    }
}