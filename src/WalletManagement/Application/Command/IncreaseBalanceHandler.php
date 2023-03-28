<?php

namespace App\WalletManagement\Application\Command;

use Doctrine\ORM\EntityManagerInterface;
use App\Shared\Application\CommandInterface;
use App\Shared\Domain\Entity\OperationFactoryInterface;
use App\Shared\Domain\Exception\WalletNotFoundException;
use App\WalletManagement\Domain\Wallet\WalletManagementRepositoryInterface;

final class IncreaseBalanceHandler implements CommandInterface
{
    public function __construct(
        private readonly WalletManagementRepositoryInterface $repository,
        private readonly EntityManagerInterface $entityManager,
        private readonly OperationFactoryInterface $operationFactory,
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

        $operation = $this->operationFactory->createDepositOperation($wallet);
        $this->entityManager->persist($operation);

        $this->entityManager->flush();
    }
}