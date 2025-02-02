<?php

declare(strict_types=1);

namespace Tests\Unit\Invoices\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\ValueObject\Price;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    #[DataProvider('validPriceProvider')]
    public function testCanCreateValidPrice(int $validPrice): void
    {
        $price = Price::create($validPrice);
        $this->assertInstanceOf(Price::class, $price);
        $this->assertSame($validPrice, $price->value);
    }

    #[DataProvider('invalidPriceProvider')]
    public function testThrowsExceptionForInvalidPrice(int $invalidPrice): void
    {
        $this->expectException(DomainException::class);
        Price::create($invalidPrice);
    }

    public static function validPriceProvider(): array
    {
        return [
            [1],
            [100],
            [99999]
        ];
    }

    public static function invalidPriceProvider(): array
    {
        return [
            [0],
            [-1],
            [-1000],
        ];
    }
}