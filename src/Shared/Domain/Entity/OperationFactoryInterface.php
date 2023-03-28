<?php

namespace App\Shared\Domain\Entity;

interface OperationFactoryInterface
{
    public function createWithdrawOperation(Wallet $wallet): Operation;

    public function createDepositOperation(Wallet $wallet): Operation;
}