<?php

declare(strict_types=1);

namespace Modules\Shared\Bus;

use Modules\Invoices\Domain\Exceptions\DomainException;

interface CommandBusInterface
{
    /**
     * @throws DomainException
     */
    public function dispatch(CommandInterface $command): void;

    public function register(array $map): void;
}