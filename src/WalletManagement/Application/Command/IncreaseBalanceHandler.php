<?php

namespace App\WalletManagement\Application\Command;

use Doctrine\ORM\EntityManagerInterface;
use App\Shared\Application\CommandInterface;
use App\Shared\Domain\Exception\WalletNotFoundException;
use App\WalletManagement\Domain\WalletManagementRepositoryInterface;

final class IncreaseBalanceHandler implements CommandInterface
{
    public function __construct(
        private readonly WalletManagementRepositoryInterface $repository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws WalletNotFoundException
     */
    public function __invoke(IncreaseBalanceCommand $command): void
    {
        $wallet = $this->repository->find($command->getId());

        $walletNotFound = is_null($wallet);
        WalletNotFoundException::throwWhen($walletNotFound, $command->getId());

        $wallet->increaseBalance($command->getAmount());

        $this->entityManager->flush();
    }
}