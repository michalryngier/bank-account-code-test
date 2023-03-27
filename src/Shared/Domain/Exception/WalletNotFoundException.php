<?php

namespace App\Shared\Domain\Exception;

use Exception;
use Ramsey\Uuid\UuidInterface;

class WalletNotFoundException extends Exception
{
    /**
     * @throws WalletNotFoundException
     */
    public static function throwWhen(bool $walletNotFound, UuidInterface $id): void
    {
        if ($walletNotFound) {
            throw new self("Wallet with id {$id->toString()} was not found.");
        }
    }
}