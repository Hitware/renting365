<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\TwoFactorCode;
use App\Models\User;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Facades\DB;

class TwoFactorAuthService
{
    /**
     * Generate and send 2FA code.
     *
     * @param User $user
     * @param string $type
     * @return TwoFactorCode
     */
    public function generateCode(User $user, string $type = 'sms'): TwoFactorCode
    {
        return DB::transaction(function () use ($user, $type) {
            // Invalidate old codes
            TwoFactorCode::where('user_id', $user->id)
                ->where('type', $type)
                ->whereNull('verified_at')
                ->delete();

            // Generate new code
            $twoFactorCode = TwoFactorCode::generate($user, $type);

            // Send notification
            $user->notify(new TwoFactorCodeNotification($twoFactorCode->code, $type));

            // Log activity
            ActivityLog::log('2fa.code.generated', 'auth', $user, [
                'type' => $type,
            ]);

            return $twoFactorCode;
        });
    }

    /**
     * Verify 2FA code.
     *
     * @param User $user
     * @param string $code
     * @param string $type
     * @return bool
     */
    public function verifyCode(User $user, string $code, string $type = 'sms'): bool
    {
        $twoFactorCode = TwoFactorCode::where('user_id', $user->id)
            ->where('code', $code)
            ->where('type', $type)
            ->valid()
            ->first();

        if (!$twoFactorCode) {
            // Log failed attempt
            ActivityLog::log('2fa.verification.failed', 'auth', $user, [
                'type' => $type,
                'reason' => 'invalid_code',
            ]);

            return false;
        }

        // Check if code is expired
        if ($twoFactorCode->isExpired()) {
            ActivityLog::log('2fa.verification.failed', 'auth', $user, [
                'type' => $type,
                'reason' => 'expired',
            ]);

            return false;
        }

        // Check attempts
        if ($twoFactorCode->hasExceededAttempts()) {
            ActivityLog::log('2fa.verification.failed', 'auth', $user, [
                'type' => $type,
                'reason' => 'max_attempts_exceeded',
            ]);

            return false;
        }

        // Verify code
        DB::transaction(function () use ($twoFactorCode, $user, $type) {
            $twoFactorCode->markAsVerified();

            // Log successful verification
            ActivityLog::log('2fa.verification.success', 'auth', $user, [
                'type' => $type,
            ]);
        });

        return true;
    }

    /**
     * Increment failed attempts.
     *
     * @param User $user
     * @param string $type
     * @return void
     */
    public function incrementAttempts(User $user, string $type = 'sms'): void
    {
        $twoFactorCode = TwoFactorCode::where('user_id', $user->id)
            ->where('type', $type)
            ->valid()
            ->first();

        if ($twoFactorCode) {
            $twoFactorCode->incrementAttempts();
        }
    }

    /**
     * Check if user has valid 2FA code.
     *
     * @param User $user
     * @param string $type
     * @return bool
     */
    public function hasValidCode(User $user, string $type = 'sms'): bool
    {
        return TwoFactorCode::where('user_id', $user->id)
            ->where('type', $type)
            ->valid()
            ->exists();
    }

    /**
     * Get remaining attempts for current code.
     *
     * @param User $user
     * @param string $type
     * @return int
     */
    public function getRemainingAttempts(User $user, string $type = 'sms'): int
    {
        $twoFactorCode = TwoFactorCode::where('user_id', $user->id)
            ->where('type', $type)
            ->valid()
            ->first();

        if (!$twoFactorCode) {
            return 0;
        }

        return max(0, TwoFactorCode::MAX_ATTEMPTS - $twoFactorCode->attempts);
    }

    /**
     * Resend 2FA code.
     *
     * @param User $user
     * @param string $type
     * @return TwoFactorCode
     */
    public function resendCode(User $user, string $type = 'sms'): TwoFactorCode
    {
        return $this->generateCode($user, $type);
    }

    /**
     * Clean up expired codes.
     *
     * @return int Number of deleted codes
     */
    public function cleanupExpiredCodes(): int
    {
        return TwoFactorCode::where('expires_at', '<', now())
            ->orWhereNotNull('verified_at')
            ->delete();
    }
}
