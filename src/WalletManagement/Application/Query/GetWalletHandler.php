<?php

namespace App\WalletManagement\Application\Query;

use App\WalletManagement\Domain\Balance;
use App\Shared\Application\QueryInterface;
use App\WalletManagement\Presentation\WalletView;
use App\WalletManagement\Domain\Wallet\WalletManagementRepositoryInterface;

class GetWalletHandler implements QueryInterface
{
    public function __construct(private readonly WalletManagementRepositoryInterface $repository)
    {
    }

    public function __invoke(GetWalletQuery $query): ?WalletView
    {
        $wallet = $this->repository->find($query->getId());

        return is_null($wallet)
            ? null
            : new WalletView(
                $wallet->getId(),
                $wallet->getName(),
                $wallet->getBalance()
            );
    }
}