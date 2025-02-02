<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Domain\UuidGeneratorInterface;
use Modules\Shared\Infrastructure\RamseyUuid;

class UuidServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UuidGeneratorInterface::class, RamseyUuid::class);
    }
}