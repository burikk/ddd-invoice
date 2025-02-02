<?php

namespace Modules\Invoices\Infrastructure\Eloquent;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\InvoiceProductLine;
use Modules\Invoices\Domain\ValueObject\InvoiceId;
use Modules\Invoices\Domain\ValueObject\Name;
use Modules\Invoices\Domain\ValueObject\Price;
use Modules\Invoices\Domain\ValueObject\ProductLineId;
use Modules\Invoices\Domain\ValueObject\Quantity;

final readonly class InvoiceProductLineMapper
{
    /**
     * @throws DomainException
     */
    public static function fromEloquent(InvoiceProductLineModel $invoiceProductLineModel): InvoiceProductLine
    {
        return new InvoiceProductLine(
            ProductLineId::fromString($invoiceProductLineModel->id),
            Name::create($invoiceProductLineModel->name),
            Price::create($invoiceProductLineModel->price),
            Quantity::create($invoiceProductLineModel->quantity),
            InvoiceId::fromString($invoiceProductLineModel->invoice_id),
        );
    }
}