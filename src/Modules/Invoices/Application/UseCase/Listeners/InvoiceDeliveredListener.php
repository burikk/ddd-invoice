<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\UseCase\Listeners;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;

final readonly class InvoiceDeliveredListener
{
    public function __construct(private InvoiceRepositoryInterface $repository)
    {
    }

    /**
     * @throws DomainException
     */
    public function __invoke(ResourceDeliveredEvent $event): void
    {
        $invoice = $this->repository->findOrFailById($event->resourceId->toString());

        $invoice->markAsDelivered();

        $this->repository->changeStatus($invoice);
    }
}