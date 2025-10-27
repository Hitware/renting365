<?php

namespace App\Http\Livewire\Auth;

use App\Models\ActivityLog;
use App\Services\UserRegistrationService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class Register extends Component
{
    // Step management
    public int $currentStep = 1;
    public int $totalSteps = 3;

    // User data
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $phone = '';

    // Profile data
    public string $first_name = '';
    public string $last_name = '';
    public string $document_type = 'CC';
    public string $document_number = '';
    public string $phone_alt = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $postal_code = '';
    public ?string $birth_date = null;

    // Role selection
    public string $role = 'client';

    // Terms acceptance
    public bool $terms_accepted = false;

    protected UserRegistrationService $registrationService;

    public function boot(UserRegistrationService $registrationService): void
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Validation rules for each step.
     */
    public function rules(): array
    {
        $rules = [
            1 => [
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'],
                'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            ],
            2 => [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'document_type' => ['required', 'in:CC,CE,TI,PAS,NIT'],
                'document_number' => ['required', 'string', 'max:50', 'unique:user_profiles,document_number'],
                'phone_alt' => ['nullable', 'string', 'max:20'],
                'address' => ['nullable', 'string'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'postal_code' => ['nullable', 'string', 'max:20'],
                'birth_date' => ['nullable', 'date', 'before:today'],
            ],
            3 => [
                'terms_accepted' => ['accepted'],
            ],
        ];

        return $rules[$this->currentStep] ?? [];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'phone.unique' => 'Este teléfono ya está registrado.',
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'document_type.required' => 'El tipo de documento es obligatorio.',
            'document_number.required' => 'El número de documento es obligatorio.',
            'document_number.unique' => 'Este número de documento ya está registrado.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'terms_accepted.accepted' => 'Debe aceptar los términos y condiciones.',
        ];
    }

    /**
     * Real-time validation for email uniqueness.
     */
    public function updatedEmail(): void
    {
        $this->validateOnly('email');
    }

    /**
     * Real-time validation for phone uniqueness.
     */
    public function updatedPhone(): void
    {
        if (!empty($this->phone)) {
            $this->validateOnly('phone');
        }
    }

    /**
     * Real-time validation for document number uniqueness.
     */
    public function updatedDocumentNumber(): void
    {
        $this->validateOnly('document_number');
    }

    /**
     * Go to next step.
     */
    public function nextStep(): void
    {
        $this->validate();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    /**
     * Go to previous step.
     */
    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Register the user.
     */
    public function register(): void
    {
        // Rate limiting
        $key = 'register:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Demasiados intentos. Por favor, intente de nuevo en {$seconds} segundos.");
            return;
        }

        RateLimiter::hit($key, 300); // 5 minutes

        $this->validate();

        try {
            $userData = [
                'email' => $this->email,
                'password' => $this->password,
                'phone' => $this->phone,
            ];

            $profileData = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'document_type' => $this->document_type,
                'document_number' => $this->document_number,
                'phone_alt' => $this->phone_alt,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'birth_date' => $this->birth_date,
            ];

            $user = $this->registrationService->register($userData, $profileData, $this->role);

            session()->flash('success', 'Registro exitoso. Por favor, verifica tu correo electrónico.');

            return redirect()->route('verification.notice');

        } catch (\Exception $e) {
            ActivityLog::log('user.registration.failed', 'users', null, [
                'error' => $e->getMessage(),
                'email' => $this->email,
            ]);

            $this->addError('registration', 'Ocurrió un error durante el registro. Por favor, intente de nuevo.');
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.auth.register');
    }
}
