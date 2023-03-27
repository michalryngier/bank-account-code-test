<?php

namespace App\WalletManagement\Application\Command;

use App\WalletManagement\Domain\WalletManagementRepositoryInterface;
use App\Shared\Domain\Entity\Wallet;
use App\Shared\Domain\Exception\CurrencyNotSupportedException;

final class CreateWalletHandler
{
    public function __construct(private readonly WalletManagementRepositoryInterface $repository)
    {
    }

    /**
     * @throws CurrencyNotSupportedException
     */
    public function __invoke(CreateWalletCommand $command): void
    {
        $wallet = new Wallet(
            $command->getId(),
            $command->getName(),
            $command->getBalance(),
        );

        $this->repository->save($wallet, true);
    }
}