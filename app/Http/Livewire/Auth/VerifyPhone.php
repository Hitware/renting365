<?php

namespace App\Http\Livewire\Auth;

use App\Services\UserRegistrationService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class VerifyPhone extends Component
{
    public string $code = '';
    public bool $verified = false;

    protected UserRegistrationService $registrationService;

    public function boot(UserRegistrationService $registrationService): void
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Validation rules.
     */
    protected function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:6', 'regex:/^[0-9]+$/'],
        ];
    }

    /**
     * Custom validation messages.
     */
    protected function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.size' => 'El código debe tener 6 dígitos.',
            'code.regex' => 'El código debe contener solo números.',
        ];
    }

    /**
     * Verify phone with code.
     */
    public function verify(): void
    {
        $this->validate();

        $key = 'verify-phone:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Demasiados intentos. Por favor, intente de nuevo en {$seconds} segundos.");
            return;
        }

        RateLimiter::hit($key, 300); // 5 minutes

        if ($this->registrationService->verifyPhone(auth()->user(), $this->code)) {
            $this->verified = true;
            session()->flash('success', 'Teléfono verificado exitosamente.');

            // Redirect after 2 seconds
            $this->dispatchBrowserEvent('phone-verified');
        } else {
            $this->addError('code', 'Código inválido o expirado.');
        }
    }

    /**
     * Resend verification code.
     */
    public function resendCode(): void
    {
        $key = 'resend-phone:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Demasiados intentos. Por favor, intente de nuevo en {$seconds} segundos.");
            return;
        }

        RateLimiter::hit($key, 600); // 10 minutes

        if (auth()->check() && !auth()->user()->hasVerifiedPhone()) {
            $this->registrationService->resendPhoneVerification(auth()->user());
            session()->flash('success', 'Se ha enviado un nuevo código de verificación.');
            $this->code = '';
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.auth.verify-phone');
    }
}
