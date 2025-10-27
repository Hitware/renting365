<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Failed;

class LogFailedLogin
{
    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        ActivityLog::log('auth.login.failed', 'auth', null, [
            'email' => $event->credentials['email'] ?? null,
            'guard' => $event->guard,
        ]);
    }
}
