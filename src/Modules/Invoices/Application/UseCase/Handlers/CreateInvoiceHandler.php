<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\UseCase\Handlers;

use Modules\Invoices\Application\UseCase\Commands\CreateInvoiceCommand;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Invoice;
use Modules\Invoices\Domain\InvoiceProductLine;
use Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Invoices\Domain\ValueObject\Email;
use Modules\Invoices\Domain\ValueObject\InvoiceId;
use Modules\Invoices\Domain\ValueObject\Name;
use Modules\Invoices\Domain\ValueObject\Price;
use Modules\Invoices\Domain\ValueObject\ProductLineId;
use Modules\Invoices\Domain\ValueObject\Quantity;
use Modules\Shared\Domain\UuidGeneratorInterface;

final readonly class CreateInvoiceHandler
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private InvoiceRepositoryInterface $repository,
    ) {
    }

    /**
     * @throws DomainException
     */
    public function handle(CreateInvoiceCommand $command): void
    {
        $invoice = Invoice::create(
            InvoiceId::fromString($this->uuidGenerator->generate()),
            Name::create($command->customerName),
            Email::create($command->customerEmail),
        );

        foreach ($command->productLines as $productLine) {
            $invoice->addProductLine(
                new InvoiceProductLine(
                    ProductLineId::fromString($this->uuidGenerator->generate()),
                    Name::create($productLine['name']),
                    Price::create($productLine['price']),
                    Quantity::create($productLine['quantity']),
                    $invoice->id,
                )
            );
        }

        $this->repository->create($invoice);
    }
}