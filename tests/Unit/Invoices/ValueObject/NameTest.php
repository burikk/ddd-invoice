<?php

declare(strict_types=1);

namespace Tests\Unit\Invoices\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\ValueObject\Name;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    public function testThrowsException(): void
    {
        $this->expectException(DomainException::class);
        Name::create('');
    }

    public function testCreatesName(): void
    {
        $name = Name::create('test');
        $this->assertInstanceOf(Name::class, $name);
        $this->assertSame('test', $name->value);
    }
}
