<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Ramsey\Uuid\UuidInterface;

readonly class Uuid
{
    /**
     * @throws DomainException
     */
    protected function __construct(public string $value)
    {
        if (!\Ramsey\Uuid\Uuid::isValid($this->value)) {
            throw new DomainException(sprintf('Invalid UUID: `<%s>`', $this->value));
        }
    }

    /**
     * @throws DomainException
     */
    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public function toRamseyUuid(): UuidInterface
    {
        return \Ramsey\Uuid\Uuid::fromString($this->value);
    }
}