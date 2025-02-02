<?php

declare(strict_types=1);

namespace Modules\Shared\Bus;

final readonly class CommandBus extends BaseBus implements CommandBusInterface
{
    public function dispatch(CommandInterface $command): void
    {
        $this->dispatcher->dispatch($command);
    }
}