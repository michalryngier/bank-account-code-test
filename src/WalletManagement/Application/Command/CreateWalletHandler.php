<?php

namespace App\WalletManagement\Application\Command;

use App\Shared\Domain\Entity\Wallet;
use App\Shared\Domain\Enum\Currency;
use App\Shared\Domain\ValueObject\BalanceFactoryInterface;
use App\Shared\Domain\Exception\CurrencyNotSupportedException;
use App\WalletManagement\Domain\Wallet\WalletManagementRepositoryInterface;

final class CreateWalletHandler
{
    public function __construct(
        private readonly WalletManagementRepositoryInterface $repository,
        private readonly BalanceFactoryInterface $balanceFactory,
    ) {
    }

    /**
     * @throws CurrencyNotSupportedException
     */
    public function __invoke(CreateWalletCommand $command): void
    {
        $currency = Currency::tryFrom($command->getCurrency());
        $currencyNotSupported = is_null($currency);
        CurrencyNotSupportedException::throwWhen($currencyNotSupported, $command->getCurrency());
        $balance = $this->balanceFactory->createBalance($currency);

        $wallet = new Wallet($command->getId(), $command->getName(), $balance);

        $this->repository->save($wallet, true);
    }
}