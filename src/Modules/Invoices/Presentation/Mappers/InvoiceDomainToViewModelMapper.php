<?php

declare(strict_types=1);

namespace Modules\Invoices\Presentation\Mappers;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Invoice;
use Modules\Invoices\Domain\InvoiceProductLine;
use Modules\Invoices\Presentation\ViewModels\InvoiceViewModel;

final readonly class InvoiceDomainToViewModelMapper
{
    /**
     * @throws DomainException
     */
    public static function map(Invoice $invoice): InvoiceViewModel
    {
        return new InvoiceViewModel(
            id: $invoice->id->value,
            status: $invoice->getStatus()->value,
            customerName: $invoice->getName()->value,
            customerEmail: $invoice->getEmail()->value,
            productLines: array_map(
                fn(InvoiceProductLine $line) => self::mapProductLine($line),
                $invoice->getProductLines()
            ),
            totalPrice: $invoice->getInvoiceTotalPrice()?->value ?? 0,
        );
    }

    /**
     * @throws DomainException
     */
    private static function mapProductLine(InvoiceProductLine $line): array
    {
        return [
            'name' => $line->getName()->value,
            'quantity' => $line->getQuantity()->value,
            'unit_price' => $line->getPrice()->value,
            'total_unit_price' => $line->getInvoiceProductLinePrice()->value,
        ];
    }
}