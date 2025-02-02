<?php

declare(strict_types=1);

namespace Modules\Shared\Domain;

interface UuidGeneratorInterface
{
    public function generate(): string;
}