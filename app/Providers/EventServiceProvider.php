<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogDeviceOnLogin;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogDeviceOnLogin::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
