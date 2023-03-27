<?php

namespace App\WalletManagement\Application\Query;

use Ramsey\Uuid\UuidInterface;
use App\Shared\Application\QueryInterface;

class GetWalletQuery implements QueryInterface
{
    public function __construct(private readonly UuidInterface $id)
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}