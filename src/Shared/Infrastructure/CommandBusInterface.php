<?php

namespace App\Shared\Infrastructure;

use App\Shared\Application\CommandInterface;

interface CommandBusInterface
{
    public function handle(CommandInterface $command): void;
}