<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;

readonly class Quantity
{
    /**
     * @throws DomainException
     */
    protected function __construct(public int $value)
    {
        if ($value < 1) {
            throw new DomainException('Quantity must be at least 1.');
        }
    }

    /**
     * @throws DomainException
     */
    public static function create(int $value): static
    {
        return new static($value);
    }
}