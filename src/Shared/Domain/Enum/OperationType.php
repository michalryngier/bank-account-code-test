<?php

namespace App\Shared\Domain\Enum;

enum OperationType: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
}