<?php

declare(strict_types=1);

namespace Tests\Feature\Notification\Http;

use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        $this->setUpFaker();

        parent::setUp();
    }

    #[DataProvider('hookActionProvider')]
    public function testHook(string $action, int $status): void
    {
        $uri = route('notification.hook', [
            'action' => $action,
            'reference' => $this->faker->uuid,
        ]);

        $response = $this->getJson($uri);
        $response->assertStatus($status);
    }

    public function testInvalid(): void
    {
        $params = [
            'action' => 'dummy',
            'reference' => $this->faker->numberBetween(),
        ];

        $uri = route('notification.hook', $params);
        $this->getJson($uri)->assertNotFound();
    }

    public static function hookActionProvider(): array
    {
        return [
            ['delivered', 424],
            ['dummy', 404],
        ];
    }
}
