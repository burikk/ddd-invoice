<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

final class UuidTest extends TestCase
{
    #[DataProvider('invalidUuidProvider')]
    public function testThrowsExceptionForInvalidUuid(string $invalidUuid): void
    {
        $this->expectException(DomainException::class);
        Uuid::fromString($invalidUuid);
    }

    public function testCanCreateValidUuid(): void
    {
        $expectedUuid = RamseyUuid::uuid4()->toString();
        $uuid = Uuid::fromString($expectedUuid);
        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertSame($expectedUuid, $uuid->value);
    }

    public function testToRamseyUuid(): void
    {
        $uuidString = RamseyUuid::uuid4()->toString();
        $uuid = Uuid::fromString($uuidString);
        $ramseyUuid = $uuid->toRamseyUuid();
        $this->assertInstanceOf(UuidInterface::class, $ramseyUuid);
        $this->assertSame($uuidString, $ramseyUuid->toString());
    }

    public static function invalidUuidProvider(): array
    {
        return [
            [''],
            ['invalid-uuid'],
            ['12345'],
            ['550e8400-e29b-41d4-a716-44665544000X'],
        ];
    }
}