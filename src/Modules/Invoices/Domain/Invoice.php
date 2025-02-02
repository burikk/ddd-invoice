<?php

declare(strict_types=1);

namespace Modules\Invoices\Domain;

use Modules\Invoices\Domain\Enums\StatusEnum;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\ValueObject\Email;
use Modules\Invoices\Domain\ValueObject\InvoiceId;
use Modules\Invoices\Domain\ValueObject\Name;
use Modules\Invoices\Domain\ValueObject\Price;

class Invoice
{
    protected function __construct(
        public readonly InvoiceId $id,
        private Name $name,
        private Email $email,
        private StatusEnum $status,
        /** @var InvoiceProductLine[] */
        private array $productLines = [],
    ) {
    }

    public static function create(InvoiceId $id, Name $name, Email $email, array $productLines = []): static
    {
        return new static($id, $name, $email, StatusEnum::Draft, $productLines);
    }

    public static function reconstitute(InvoiceId $id, Name $name, Email $email, StatusEnum $status, array $productLines): static
    {
        return new static($id, $name, $email, $status, $productLines);
    }

    /**
     * @throws DomainException
     */
    public function addProductLine(InvoiceProductLine $productLine): void
    {
        if ($this->status !== StatusEnum::Draft) {
            throw new DomainException('Product lines can only be added when the invoice is in draft status.');
        }

        $this->productLines[] = $productLine;
    }

    /**
     * @throws DomainException
     */
    public function send(): void
    {
        $this->status->transition($this)->toSending();
        $this->status = StatusEnum::Sending;
    }

    /**
     * @throws DomainException
     */
    public function markAsDelivered(): void
    {
        $this->status->transition($this)->toDelivered();
        $this->status = StatusEnum::SentToClient;
    }

    /**
     * @throws DomainException
     */
    public function getInvoiceTotalPrice(): ?Price
    {
        if ($this->productLines === []) {
            return null;
        }

        $value = 0;
        foreach ($this->productLines as $line) {
            $value += $line->getInvoiceProductLinePrice()->value;
        }

        return Price::create($value);
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getProductLines(): array
    {
        return $this->productLines;
    }
}