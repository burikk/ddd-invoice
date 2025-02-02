<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\State;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Shared\Domain\State\StatusInterface;

final readonly class SentStatus implements StatusInterface
{
    /**
     * @throws DomainException
     */
    public function toSending(): StatusInterface
    {
        throw new DomainException('Invoice is already sent.');
    }

    /**
     * @throws DomainException
     */
    public function toDelivered(): StatusInterface
    {
        throw new DomainException('Invoice is already sent.');
    }
}