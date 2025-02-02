<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\UseCase\Handlers;

use Modules\Invoices\Application\UseCase\Queries\ViewInvoiceQuery;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Invoices\Presentation\Mappers\InvoiceDomainToViewModelMapper;
use Modules\Invoices\Presentation\ViewModels\InvoiceViewModel;

final readonly class ViewInvoiceHandler
{
    public function __construct(private InvoiceRepositoryInterface $repository)
    {
    }

    /**
     * @throws DomainException
     */
    public function handle(ViewInvoiceQuery $query): InvoiceViewModel
    {
        $invoice = $this->repository->findOrFailById($query->id);

        return InvoiceDomainToViewModelMapper::map($invoice);
    }
}