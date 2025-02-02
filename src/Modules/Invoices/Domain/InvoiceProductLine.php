<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\ValueObject\InvoiceId;
use Modules\Invoices\Domain\ValueObject\Name;
use Modules\Invoices\Domain\ValueObject\Price;
use Modules\Invoices\Domain\ValueObject\ProductLineId;
use Modules\Invoices\Domain\ValueObject\Quantity;

class InvoiceProductLine
{
    public function __construct(
        public readonly ProductLineId $id,
        private Name $name,
        private Price $price,
        private Quantity $quantity,
        public readonly InvoiceId $invoiceId,
    ) {
    }

    /**
     * @throws DomainException
     */
    public function getInvoiceProductLinePrice(): Price
    {
        return Price::create($this->price->value * $this->quantity->value);
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }
}