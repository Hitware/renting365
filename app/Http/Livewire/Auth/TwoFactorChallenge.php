<?php

namespace App\Http\Livewire\Auth;

use App\Services\TwoFactorAuthService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class TwoFactorChallenge extends Component
{
    public string $code = '';
    public string $type = 'sms';
    public int $remainingAttempts = 3;
    public bool $codeResent = false;

    protected TwoFactorAuthService $twoFactorService;

    public function boot(TwoFactorAuthService $twoFactorService): void
    {
        $this->twoFactorService = $twoFactorService;
    }

    public function mount(): void
    {
        if (!session()->has('2fa.user_id')) {
            return redirect()->route('login');
        }

        $this->updateRemainingAttempts();
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
     * Verify the 2FA code.
     */
    public function verify(): void
    {
        $this->validate();

        $userId = session()->get('2fa.user_id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $key = '2fa-verify:' . $userId;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Demasiados intentos. Por favor, intente de nuevo en {$seconds} segundos.");
            return;
        }

        if ($this->twoFactorService->verifyCode($user, $this->code, $this->type)) {
            RateLimiter::clear($key);

            // Clear 2FA session
            session()->forget('2fa.user_id');

            // Log the user in
            auth()->login($user, session()->get('2fa.remember', false));

            // Update last login
            $user->updateLastLogin();

            session()->flash('success', 'Autenticación exitosa.');

            return redirect()->intended(route('dashboard'));
        } else {
            RateLimiter::hit($key, 300); // 5 minutes

            $this->twoFactorService->incrementAttempts($user, $this->type);
            $this->updateRemainingAttempts();

            $this->addError('code', 'Código inválido o expirado. Intentos restantes: ' . $this->remainingAttempts);
            $this->code = '';

            if ($this->remainingAttempts === 0) {
                session()->forget('2fa.user_id');
                session()->flash('error', 'Se han excedido los intentos permitidos. Por favor, inicie sesión nuevamente.');
                return redirect()->route('login');
            }
        }
    }

    /**
     * Resend the 2FA code.
     */
    public function resendCode(): void
    {
        $userId = session()->get('2fa.user_id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $key = 'resend-2fa:' . $userId;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Demasiados intentos. Por favor, intente de nuevo en {$seconds} segundos.");
            return;
        }

        RateLimiter::hit($key, 600); // 10 minutes

        $this->twoFactorService->resendCode($user, $this->type);
        $this->codeResent = true;
        $this->code = '';

        session()->flash('success', 'Se ha enviado un nuevo código de verificación.');

        // Reset the flag after 5 seconds
        $this->dispatchBrowserEvent('code-resent');
    }

    /**
     * Update remaining attempts.
     */
    private function updateRemainingAttempts(): void
    {
        $userId = session()->get('2fa.user_id');
        $user = \App\Models\User::find($userId);

        if ($user) {
            $this->remainingAttempts = $this->twoFactorService->getRemainingAttempts($user, $this->type);
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.auth.two-factor-challenge');
    }
}
