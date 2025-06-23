<?php

namespace App\Listeners;

use App\Models\deviceLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Jenssegers\Agent\Agent;
class LogDeviceOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
  public function handle(Login $event): void
    {
        $agent = new Agent();

        deviceLog::create([
            'user_id' => $event->user->id,
            'device_name' => $agent->device(),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
            'ip_address' => request()->ip(),
            'last_login_at' => now(),
        ]);
    }
}
