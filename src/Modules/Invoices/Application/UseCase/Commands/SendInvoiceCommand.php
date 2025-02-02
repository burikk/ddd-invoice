<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\UseCase\Commands;

use Modules\Shared\Bus\CommandInterface;

final readonly class SendInvoiceCommand implements CommandInterface
{
    public function __construct(public string $id)
    {
    }
}