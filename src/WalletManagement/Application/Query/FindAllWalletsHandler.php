<?php

namespace App\WalletManagement\Application\Query;

use App\Shared\Application\QueryInterface;
use App\WalletManagement\Presentation\WalletListView;
use App\WalletManagement\Domain\WalletManagementRepositoryInterface;

final class FindAllWalletsHandler implements QueryInterface
{
    public function __construct(private readonly WalletManagementRepositoryInterface $repository)
    {
    }

    public function __invoke(FindAllWalletsQuery $query): ?WalletListView
    {
        $wallets = $this->repository->findAll();

        return new WalletListView($wallets);
    }
}