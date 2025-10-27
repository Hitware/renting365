<?php

namespace App\Http\Livewire\Auth;

use App\Services\UserRegistrationService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class VerifyEmail extends Component
{
    public ?string $token = null;
    public bool $verified = false;
    public bool $invalid = false;

    protected UserRegistrationService $registrationService;

    public function boot(UserRegistrationService $registrationService): void
    {
        $this->registrationService = $registrationService;
    }

    public function mount(?string $token = null): void
    {
        $this->token = $token ?? request()->query('token');

        if ($this->token) {
            $this->verifyToken();
        }
    }

    /**
     * Verify the email token.
     */
    public function verifyToken(): void
    {
        if ($this->registrationService->verifyEmail($this->token)) {
            $this->verified = true;
            session()->flash('success', 'Correo electrónico verificado exitosamente.');
        } else {
            $this->invalid = true;
        }
    }

    /**
     * Resend verification email.
     */
    public function resendVerification(): void
    {
        $key = 'resend-verification:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Demasiados intentos. Por favor, intente de nuevo en {$seconds} segundos.");
            return;
        }

        RateLimiter::hit($key, 600); // 10 minutes

        if (auth()->check() && !auth()->user()->hasVerifiedEmail()) {
            $this->registrationService->resendEmailVerification(auth()->user());
            session()->flash('success', 'Se ha enviado un nuevo correo de verificación.');
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
