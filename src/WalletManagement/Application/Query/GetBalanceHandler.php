<?php

namespace App\WalletManagement\Application\Query;

use Ramsey\Uuid\UuidInterface;
use App\WalletManagement\Presentation\WalletView;
use App\Shared\Application\QueryInterface;
use App\WalletManagement\Domain\WalletRepositoryInterface;

final class GetBalanceHandler implements QueryInterface
{
    public function __construct(private readonly WalletRepositoryInterface $repository)
    {
    }

    public function __invoke(GetBalanceQuery $query): ?WalletView
    {
        $wallet = $this->repository->find($query->getId());

        return is_null($wallet)
            ? null
            : new WalletView($wallet->getId(), $wallet->getName(), $wallet->getBalance());
    }
}