<?php

namespace App\WalletManagement\Domain\Operation;

use Ramsey\Uuid\Uuid;
use App\Shared\Domain\Entity\Wallet;
use App\Shared\Domain\Entity\Operation;
use App\Shared\Domain\Enum\OperationType;
use App\Shared\Domain\ValueObject\OperationData;
use App\Shared\Domain\Entity\OperationFactoryInterface;

class OperationFactory implements OperationFactoryInterface
{
    public function createWithdrawOperation(Wallet $wallet): Operation
    {
        $operationData = new OperationData($wallet->getOldBalance(), $wallet->getBalance());

        return new Operation(
            Uuid::uuid4(),
            $wallet,
            OperationType::WITHDRAW,
            $operationData
        );
    }

    public function createDepositOperation(Wallet $wallet): Operation
    {
        $operationData = new OperationData($wallet->getOldBalance(), $wallet->getBalance());

        return new Operation(
            Uuid::uuid4(),
            $wallet,
            OperationType::DEPOSIT,
            $operationData
        );
    }
}