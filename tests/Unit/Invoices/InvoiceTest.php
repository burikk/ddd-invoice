<?php

declare(strict_types=1);

namespace Tests\Unit\Invoices;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Invoices\Domain\Enums\StatusEnum;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\Invoice;
use Modules\Invoices\Domain\InvoiceProductLine;
use Modules\Invoices\Domain\ValueObject\Email;
use Modules\Invoices\Domain\ValueObject\InvoiceId;
use Modules\Invoices\Domain\ValueObject\Name;
use Modules\Invoices\Domain\ValueObject\Price;
use Modules\Invoices\Domain\ValueObject\ProductLineId;
use Modules\Invoices\Domain\ValueObject\Quantity;
use PHPUnit\Framework\TestCase;

final class InvoiceTest extends TestCase
{
    use WithFaker;

    private Invoice $invoice;
    private InvoiceProductLine $invoiceProductLine;

    protected function setUp(): void
    {
        $this->setUpFaker();

        $this->invoice = Invoice::create(
            InvoiceId::fromString($this->faker->uuid),
            Name::create('Sample Invoice'),
            Email::create('sample@example.com')
        );

        $this->invoiceProductLine = new InvoiceProductLine(
            ProductLineId::fromString($this->faker->uuid),
            Name::create($this->faker->word),
            Price::create(100),
            Quantity::create(2),
            InvoiceId::fromString($this->invoice->id->value),
        );
    }

    public function testCreatedInDraftStatus(): void
    {
        $this->assertEquals(StatusEnum::Draft, $this->invoice->getStatus());
    }

    public function testCreatedWithEmptyLines(): void
    {
        $this->assertSame([], $this->invoice->getProductLines());
    }

    public function testSendWithEmptyLinesFails(): void
    {
        $this->expectException(DomainException::class);
        $this->invoice->send();
    }

    public function testMarkAsDeliveredDraftInvoiceFails(): void
    {
        $this->expectException(DomainException::class);
        $this->invoice->markAsDelivered();
    }

    public function testAddProductLineInDraftStatus(): void
    {
        $this->invoice->addProductLine($this->invoiceProductLine);

        $this->assertCount(1, $this->invoice->getProductLines());
        foreach ($this->invoice->getProductLines() as $productLine) {
            $this->assertEquals($this->invoiceProductLine, $productLine);
        }
    }

    public function testSendDraft(): void
    {
        $this->invoice->addProductLine($this->invoiceProductLine);
        $this->invoice->send();
        $this->assertEquals(StatusEnum::Sending, $this->invoice->getStatus());
    }

    public function testAddProductLineInNonDraftStatusFails(): void
    {
        $this->expectException(DomainException::class);
        $this->invoice->addProductLine($this->invoiceProductLine);
        $this->invoice->send();
        $this->invoice->addProductLine($this->invoiceProductLine);
    }

    public function testMarkAsDelivered(): void
    {
        $this->invoice->addProductLine($this->invoiceProductLine);
        $this->invoice->send();
        $this->invoice->markAsDelivered();

        $this->assertEquals(StatusEnum::SentToClient, $this->invoice->getStatus());
    }

    public function testGetInvoiceTotalPriceWithEmptyLines(): void
    {
        $this->assertNull($this->invoice->getInvoiceTotalPrice());
    }

    public function testGetInvoiceTotalPriceWithProductLines(): void
    {
        $this->invoice->addProductLine($this->invoiceProductLine);
        $this->invoice->addProductLine($this->invoiceProductLine);
        $this->assertEquals(Price::create(400), $this->invoice->getInvoiceTotalPrice());
    }
}
