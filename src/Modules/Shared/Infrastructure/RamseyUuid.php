<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure;

use Modules\Shared\Domain\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

class RamseyUuid implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}