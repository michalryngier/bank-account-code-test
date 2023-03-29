<?php

namespace App\Reporting\Infrastructure;

use App\Reporting\Domain\Enum\ReportFormat;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Shared\Domain\Exception\InvalidReportFormatException;
use App\Reporting\Domain\Wallet\WalletReportingRepositoryInterface;
use App\Reporting\Application\ReportGenerator\WalletOperationsReportGeneratorFactoryInterface;

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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $wallet = $this->walletRepository->find($input->getArgument('wallet-id'));
        $reportFormat = ReportFormat::tryFrom(strtolower($input->getArgument('format')));

        try {
            $reportGenerator = $this->reportGeneratorFactory->create($reportFormat);
        } catch (InvalidReportFormatException $e) {
            $io->error("An error occurred during report generation: {$e->getMessage()}");

            return Command::FAILURE;
        }

        $reportGenerated = $reportGenerator->generateReport($wallet);

        if ($reportGenerated === false) {
            $io->error("Error occurred during report generation process.");

            return Command::FAILURE;
        }

        $io->success("Report for {$wallet->getId()} has been generated.");

        return Command::SUCCESS;
    }
}