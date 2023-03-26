<?php

namespace App\WalletManagement\Application\Command;

use App\WalletManagement\Domain\Wallet;
use App\WalletManagement\Domain\WalletRepositoryInterface;

class CreateWalletHandler
{
    public function __construct(private readonly WalletRepositoryInterface $repository)
    {
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $wallet = new Wallet(
            $command->getId(),
            $command->getName(),
            $command->getBalance(),
        );

        $this->repository->save($wallet);
    }
}