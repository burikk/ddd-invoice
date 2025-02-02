<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\Repository;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Invoice;

interface InvoiceRepositoryInterface
{
    public function create(Invoice $invoice): void;

    /**
     * @throws DomainException
     */
    public function findOrFailById(string $id): Invoice;

    /**
     * @throws DomainException
     */
    public function changeStatus(Invoice $invoice): void;
}