<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\VerificationToken;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\PhoneVerificationNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRegistrationService
{
    /**
     * Register a new user with profile and role assignment.
     *
     * @param array $userData
     * @param array $profileData
     * @param string $roleSlug
     * @return User
     * @throws \Exception
     */
    public function register(array $userData, array $profileData, string $roleSlug = 'client'): User
    {
        return DB::transaction(function () use ($userData, $profileData, $roleSlug) {
            // Create user
            $user = User::create([
                'name' => $profileData['first_name'] . ' ' . $profileData['last_name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'phone' => $userData['phone'] ?? null,
                'is_active' => true,
            ]);

            // Create user profile
            $user->profile()->create($profileData);

            // Assign role
            $role = Role::where('slug', $roleSlug)->firstOrFail();
            $user->assignRole($role);

            // Generate email verification token
            $emailToken = VerificationToken::generate($user, 'email', 1440); // 24 hours

            // Send email verification
            $user->notify(new EmailVerificationNotification($emailToken->token));

            // Generate phone verification token if phone provided
            if (!empty($userData['phone'])) {
                $phoneToken = VerificationToken::generate($user, 'phone', 30); // 30 minutes
                $user->notify(new PhoneVerificationNotification($phoneToken->token));
            }

            // Log activity
            ActivityLog::log('user.registered', 'users', $user, [
                'role' => $roleSlug,
                'email' => $userData['email'],
                'phone' => $userData['phone'] ?? null,
            ]);

            return $user->load('profile', 'roles');
        });
    }

    /**
     * Verify email with token.
     *
     * @param string $token
     * @return bool
     */
    public function verifyEmail(string $token): bool
    {
        $verificationToken = VerificationToken::where('token', $token)
            ->where('type', 'email')
            ->valid()
            ->first();

        if (!$verificationToken) {
            return false;
        }

        $user = $verificationToken->user;

        DB::transaction(function () use ($user, $verificationToken) {
            // Mark token as verified
            $verificationToken->markAsVerified();

            // Mark user email as verified
            $user->markEmailAsVerified();

            // Log activity
            ActivityLog::log('email.verified', 'users', $user);
        });

        return true;
    }

    /**
     * Verify phone with token.
     *
     * @param User $user
     * @param string $token
     * @return bool
     */
    public function verifyPhone(User $user, string $token): bool
    {
        $verificationToken = VerificationToken::where('user_id', $user->id)
            ->where('token', $token)
            ->where('type', 'phone')
            ->valid()
            ->first();

        if (!$verificationToken) {
            return false;
        }

        DB::transaction(function () use ($user, $verificationToken) {
            // Mark token as verified
            $verificationToken->markAsVerified();

            // Mark user phone as verified
            $user->markPhoneAsVerified();

            // Log activity
            ActivityLog::log('phone.verified', 'users', $user);
        });

        return true;
    }

    /**
     * Resend verification email.
     *
     * @param User $user
     * @return void
     */
    public function resendEmailVerification(User $user): void
    {
        // Invalidate old tokens
        VerificationToken::where('user_id', $user->id)
            ->where('type', 'email')
            ->whereNull('verified_at')
            ->delete();

        // Generate new token
        $token = VerificationToken::generate($user, 'email', 1440);

        // Send notification
        $user->notify(new EmailVerificationNotification($token->token));

        // Log activity
        ActivityLog::log('email.verification.resent', 'users', $user);
    }

    /**
     * Resend phone verification.
     *
     * @param User $user
     * @return void
     */
    public function resendPhoneVerification(User $user): void
    {
        // Invalidate old tokens
        VerificationToken::where('user_id', $user->id)
            ->where('type', 'phone')
            ->whereNull('verified_at')
            ->delete();

        // Generate new token
        $token = VerificationToken::generate($user, 'phone', 30);

        // Send notification
        $user->notify(new PhoneVerificationNotification($token->token));

        // Log activity
        ActivityLog::log('phone.verification.resent', 'users', $user);
    }

    /**
     * Check if email is already registered.
     *
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    /**
     * Check if phone is already registered.
     *
     * @param string $phone
     * @return bool
     */
    public function phoneExists(string $phone): bool
    {
        return User::where('phone', $phone)->exists();
    }

    /**
     * Check if document number is already registered.
     *
     * @param string $documentNumber
     * @return bool
     */
    public function documentExists(string $documentNumber): bool
    {
        return UserProfile::where('document_number', $documentNumber)->exists();
    }
}
