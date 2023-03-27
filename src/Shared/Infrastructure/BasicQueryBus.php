<?php

namespace App\Shared\Infrastructure;

use App\Shared\Application\QueryInterface;
use App\Shared\Domain\Exception\HandlerNotFoundException;

class BasicQueryBus implements QueryBusInterface
{
    private array $handlers = [];

    public function map(string $command, callable $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    /**
     * @throws HandlerNotFoundException
     */
    public function handle(QueryInterface $query): ?object
    {
        $fqcn = get_class($query);
        $handlerNotFound = isset($this->handlers[$fqcn]) === false;
        HandlerNotFoundException::throwWhen($handlerNotFound, $fqcn);

        return call_user_func($this->handlers[$fqcn], $query);
    }
}