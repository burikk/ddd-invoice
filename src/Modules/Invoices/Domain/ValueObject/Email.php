<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;

readonly class Email
{
    /**
     * @throws DomainException
     */
    protected function __construct(public string $value)
    {
        if ($this->value === '') {
            throw new DomainException('Email cannot be empty.');
        }

        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException('Invalid email format.');
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