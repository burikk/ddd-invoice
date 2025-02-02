<?php

declare(strict_types=1);

namespace Modules\Invoices\Presentation\ViewModels;

final readonly class InvoiceViewModel implements \JsonSerializable
{
    public function __construct(
        public string $id,
        public string $status,
        public string $customerName,
        public string $customerEmail,
        public array $productLines,
        public int $totalPrice,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'customer_name' => $this->customerName,
            'customer_email' => $this->customerEmail,
            'product_lines' => $this->productLines,
            'total_price' => $this->totalPrice,
        ];
    }
}