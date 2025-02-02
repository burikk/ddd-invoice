<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;

readonly class Name
{
    /**
     * @throws DomainException
     */
    protected function __construct(public string $value)
    {
        if ($this->value === '') {
            throw new DomainException('Name cannot be empty.');
        }
    }

    /**
     * @throws DomainException
     */
    public static function create(string $value): static
    {
        return new static($value);
    }
}