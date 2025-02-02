<?php

declare(strict_types=1);

namespace Tests\Unit\Invoices\ValueObject;

use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Domain\ValueObject\Email;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testCanCreateValidEmail(): void
    {
        $email = Email::create('test@example.com');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertSame('test@example.com', $email->value);
    }

    #[DataProvider('invalidEmailProvider')]
    public function testThrowsExceptionForInvalidEmail(string $invalidEmail): void
    {
        $this->expectException(DomainException::class);
        Email::create($invalidEmail);
    }

    public static function invalidEmailProvider(): array
    {
        return [
            [''],
            ['invalid-email'],
            ['user@'],
            ['@domain.com'],
            ['user@domain'],
            ['user@domain,com'],
        ];
    }
}
