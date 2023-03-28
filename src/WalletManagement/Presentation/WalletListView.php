<?php

namespace App\WalletManagement\Presentation;


use App\Shared\Domain\Entity\Wallet;

class WalletListView
{
    /**
     * @param Wallet[] $wallets
     */
    public function __construct(
        private readonly array $wallets = []
    ) {
    }

    public function showWallets(): array
    {
        $list = [];

        foreach ($this->wallets as $wallet) {
            $list[] = [
                'id' => $wallet->getId(),
                'balance' => $wallet->getBalance()->toString()
            ];
        }

        return $list;
    }
}