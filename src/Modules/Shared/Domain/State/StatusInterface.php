<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\State;

use Modules\Invoices\Domain\Exceptions\DomainException;

interface StatusInterface
{
    /**
     * @throws DomainException
     */
    public function toSending(): StatusInterface;

    /**
     * @throws DomainException
     */
    public function toDelivered(): StatusInterface;
}