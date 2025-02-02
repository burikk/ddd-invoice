<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\State;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Shared\Domain\State\StatusInterface;

final readonly class SendingStatus implements StatusInterface
{
    /**
     * @throws DomainException
     */
    public function toSending(): StatusInterface
    {
        throw new DomainException('Invoice is already being sent.');
    }

    public function toDelivered(): StatusInterface
    {
        return new SentStatus();
    }
}