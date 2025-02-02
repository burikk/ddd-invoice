<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\UseCase\Handlers;

use Modules\Invoices\Application\UseCase\Commands\SendInvoiceCommand;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Notifications\Api\Dtos\NotifyData;
use Modules\Notifications\Api\NotificationFacadeInterface;

final readonly class SendInvoiceHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
        private NotificationFacadeInterface $notificationFacade,
    ) {
    }

    /**
     * @throws DomainException
     */
    public function handle(SendInvoiceCommand $command): void
    {
        $invoice = $this->repository->findOrFailById($command->id);
        $invoice->send();

        $this->repository->changeStatus($invoice);

        $this->notificationFacade->notify(
            new NotifyData(
                $invoice->id->toRamseyUuid(),
                $invoice->getEmail()->value,
                sprintf('Invoice - `<%s>`', $invoice->getName()->value),
                'Sending you an invoice.',
            )
        );
    }
}