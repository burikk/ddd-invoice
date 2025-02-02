<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\State;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Invoice;
use Modules\Shared\Domain\State\StatusInterface;

final readonly class DraftStatus implements StatusInterface
{
    public function __construct(private Invoice $invoice)
    {
    }

    /**
     * @throws DomainException
     */
    public function toSending(): StatusInterface
    {
        if ($this->invoice->getProductLines() === []) {
            throw new DomainException('Product lines cannot be empty');
        }

        return new SendingStatus();
    }

    /**
     * @throws DomainException
     */
    public function toDelivered(): StatusInterface
    {
        throw new DomainException('Draft invoice cannot be marked as delivered.');
    }
}