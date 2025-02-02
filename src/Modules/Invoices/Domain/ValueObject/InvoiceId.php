<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\ValueObject;

use Modules\Shared\Domain\ValueObject\Uuid;

final readonly class InvoiceId extends Uuid
{
}