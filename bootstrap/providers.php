<?php

return [
    \Modules\Notifications\Infrastructure\Providers\NotificationServiceProvider::class,
    \Modules\Shared\Bus\BusServiceProvider::class,
    \Modules\Invoices\Infrastructure\Providers\InvoiceServiceProvider::class,
    \Modules\Shared\Infrastructure\Providers\UuidServiceProvider::class,
];
