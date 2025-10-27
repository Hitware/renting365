<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityLog::log('user.created', 'users', $user, [
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $changes = $user->getChanges();

        // Don't log certain fields
        $excludedFields = ['updated_at', 'remember_token', 'last_login_at'];
        $changes = array_diff_key($changes, array_flip($excludedFields));

        if (!empty($changes)) {
            ActivityLog::log('user.updated', 'users', $user, [
                'changes' => $changes,
                'original' => $user->getOriginal(),
            ]);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        ActivityLog::log('user.deleted', 'users', $user, [
            'email' => $user->email,
            'deleted_at' => now(),
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        ActivityLog::log('user.restored', 'users', $user, [
            'email' => $user->email,
        ]);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        ActivityLog::log('user.force_deleted', 'users', null, [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }
}
