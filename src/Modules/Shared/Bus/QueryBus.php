<?php

declare(strict_types=1);

namespace Modules\Shared\Bus;

final readonly class QueryBus extends BaseBus implements QueryBusInterface
{
    public function ask(QueryInterface $query): \JsonSerializable
    {
        return $this->dispatcher->dispatch($query);
    }
}