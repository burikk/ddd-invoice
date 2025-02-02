<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\Enums;

use Modules\Invoices\Domain\Invoice;
use Modules\Invoices\Domain\State\DraftStatus;
use Modules\Invoices\Domain\State\SendingStatus;
use Modules\Invoices\Domain\State\SentStatus;
use Modules\Shared\Domain\State\StatusInterface;

enum StatusEnum: string
{
    case Draft = 'draft';
    case Sending = 'sending';
    case SentToClient = 'sent-to-client';

    public function transition(Invoice $invoice): StatusInterface
    {
        return match ($this) {
            StatusEnum::Draft => new DraftStatus($invoice),
            StatusEnum::Sending => new SendingStatus(),
            StatusEnum::SentToClient => new SentStatus(),
        };
    }
}
