<?php

declare(strict_types=1);

namespace Modules\Invoices\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Invoice;
use Modules\Invoices\Domain\InvoiceProductLine;
use Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Invoices\Domain\ValueObject\Email;
use Modules\Invoices\Domain\ValueObject\InvoiceId;
use Modules\Invoices\Domain\ValueObject\Name;

final readonly class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function create(Invoice $invoice): void
    {
        $invoiceModel = InvoiceModel::create([
            'id' => $invoice->id->value,
            'customer_name' => $invoice->getName()->value,
            'customer_email' => $invoice->getEmail()->value,
            'status' => $invoice->getStatus()->value,
        ]);

        $invoiceProductLines = $invoice->getProductLines();

        if ($invoiceProductLines !== []) {
            $invoiceModel
                ->productLines()
                ->createMany(
                    collect($invoiceProductLines)
                        ->map(function (InvoiceProductLine $productLine) use ($invoiceModel) {
                            return [
                                'id' => $productLine->id->value,
                                'name' => $productLine->getName()->value,
                                'price' => $productLine->getPrice()->value,
                                'quantity' => $productLine->getQuantity()->value,
                                'invoice_id' => $invoiceModel->id,
                            ];
                        })
                );
        }
    }


    /**
     * @throws DomainException
     */
    public function findOrFailById(string $id): Invoice
    {
        try {
            $invoiceModel = InvoiceModel::with('productLines')->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new DomainException("Invoice resource with id {$id} not found.");
        }

        $productLines = array_map(
            fn($productLineModel) => InvoiceProductLineMapper::fromEloquent($productLineModel),
            $invoiceModel->productLines->all()
        );

        return Invoice::reconstitute(
            id: InvoiceId::fromString($invoiceModel->id),
            name: Name::create($invoiceModel->customer_name),
            email: Email::create($invoiceModel->customer_email),
            status: $invoiceModel->status,
            productLines: $productLines,
        );
    }

    /**
     * @throws DomainException
     */
    public function changeStatus(Invoice $invoice): void
    {
        try {
            $invoiceModel = InvoiceModel::findOrFail($invoice->id->value);
        } catch (ModelNotFoundException) {
            throw new DomainException("Invoice with id {$invoice->id->value} not found.");
        }

        $invoiceModel->status = $invoice->getStatus()->value;
        $invoiceModel->save();
    }
}