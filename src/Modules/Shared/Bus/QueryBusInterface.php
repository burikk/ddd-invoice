<?php

declare(strict_types=1);

namespace Modules\Shared\Bus;

use Modules\Invoices\Domain\Exceptions\DomainException;

interface QueryBusInterface
{
    /**
     * @throws DomainException
     */
    public function ask(QueryInterface $query): \JsonSerializable;

    public function register(array $map): void;
}