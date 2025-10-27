<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\UserProfile;

class UserProfileObserver
{
    /**
     * Handle the UserProfile "created" event.
     */
    public function created(UserProfile $profile): void
    {
        ActivityLog::log('profile.created', 'users', $profile->user, [
            'document_type' => $profile->document_type,
            'document_number' => $profile->document_number,
        ]);
    }

    /**
     * Handle the UserProfile "updated" event.
     */
    public function updated(UserProfile $profile): void
    {
        $changes = $profile->getChanges();

        // Don't log timestamp fields
        $excludedFields = ['updated_at'];
        $changes = array_diff_key($changes, array_flip($excludedFields));

        if (!empty($changes)) {
            ActivityLog::log('profile.updated', 'users', $profile->user, [
                'changes' => $changes,
            ]);
        }
    }

    /**
     * Handle the UserProfile "deleted" event.
     */
    public function deleted(UserProfile $profile): void
    {
        ActivityLog::log('profile.deleted', 'users', $profile->user);
    }
}
