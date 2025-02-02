<?php

declare(strict_types=1);

namespace Tests\Unit\Invoices\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\ValueObject\Quantity;
use PHPUnit\Framework\TestCase;

final class QuantityTest extends TestCase
{
    public function testCanBeCreatedWithValidValue(): void
    {
        $quantity = Quantity::create(5);

        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertSame(5, $quantity->value);
    }

    public function testQuantityCannotBeCreatedWithZero(): void
    {
        $this->expectException(DomainException::class);
        Quantity::create(0);
    }

    public function testQuantityCannotBeCreatedWithNegativeValue(): void
    {
        $this->expectException(DomainException::class);
        Quantity::create(-3);
    }
}