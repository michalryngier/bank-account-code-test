<?php

namespace App\Shared\Infrastructure;

use App\Shared\Application\CommandInterface;

use App\Shared\Exception\HandlerNotFoundException;

use function get_class;

class SynchronousCommandBus implements CommandBusInterface
{
    private array $handlers = [];

    public function map(string $command, callable $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    /**
     * @throws HandlerNotFoundException
     */
    public function handle(CommandInterface $command): void
    {
        $fqcn = get_class($command);
        $handlerNotFound = isset($this->handlers[$fqcn]) === false;
        HandlerNotFoundException::throwWhen($handlerNotFound, $fqcn);

        call_user_func($this->handlers[$fqcn], $command);
    }
}