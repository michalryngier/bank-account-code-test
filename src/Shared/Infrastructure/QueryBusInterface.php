<?php

namespace App\Shared\Infrastructure;

use App\Shared\Application\QueryInterface;

interface QueryBusInterface
{
    public function handle(QueryInterface $query): ?object;
}