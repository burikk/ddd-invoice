<?php

declare(strict_types=1);

namespace Tests\Unit\Invoices;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Invoices\Domain\InvoiceProductLine;
use Modules\Invoices\Domain\ValueObject\InvoiceId;
use Modules\Invoices\Domain\ValueObject\Name;
use Modules\Invoices\Domain\ValueObject\Price;
use Modules\Invoices\Domain\ValueObject\ProductLineId;
use Modules\Invoices\Domain\ValueObject\Quantity;
use PHPUnit\Framework\TestCase;

final class InvoiceProductLineTest extends TestCase
{
    use WithFaker;

    private InvoiceProductLine $productLine;

    protected function setUp(): void
    {
        $this->setUpFaker();

        $this->productLine = new InvoiceProductLine(
            ProductLineId::fromString($this->faker->uuid),
            Name::create('Product A'),
            Price::create(100),
            Quantity::create(2),
            InvoiceId::fromString($this->faker->uuid)
        );
    }

    public function testCanCreateInvoiceProductLine(): void
    {
        $this->assertInstanceOf(InvoiceProductLine::class, $this->productLine);
        $this->assertInstanceOf(ProductLineId::class, $this->productLine->id);
        $this->assertInstanceOf(Name::class, $this->productLine->getName());
        $this->assertInstanceOf(Price::class, $this->productLine->getPrice());
        $this->assertInstanceOf(Quantity::class, $this->productLine->getQuantity());
        $this->assertInstanceOf(InvoiceId::class, $this->productLine->invoiceId);
    }

    public function testGetInvoiceProductLinePrice(): void
    {
        $totalPrice = $this->productLine->getInvoiceProductLinePrice();

        $this->assertInstanceOf(Price::class, $totalPrice);
        $this->assertSame(200, $totalPrice->value);
    }
}