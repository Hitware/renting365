<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    private array $failedRequirements = [];

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        $this->failedRequirements = [];

        // Minimum 8 characters
        if (strlen($value) < 8) {
            $this->failedRequirements[] = 'al menos 8 caracteres';
        }

        // At least one lowercase letter
        if (!preg_match('/[a-z]/', $value)) {
            $this->failedRequirements[] = 'una letra minúscula';
        }

        // At least one uppercase letter
        if (!preg_match('/[A-Z]/', $value)) {
            $this->failedRequirements[] = 'una letra mayúscula';
        }

        // At least one digit
        if (!preg_match('/\d/', $value)) {
            $this->failedRequirements[] = 'un número';
        }

        // At least one special character
        if (!preg_match('/[@$!%*?&#^()_\-+=\[\]{}|:;,.<>~]/', $value)) {
            $this->failedRequirements[] = 'un carácter especial (@$!%*?&#, etc.)';
        }

        // Check for common weak passwords
        $weakPasswords = ['password', '12345678', 'qwerty123', 'abc12345', 'password123'];
        if (in_array(strtolower($value), $weakPasswords)) {
            $this->failedRequirements[] = 'una contraseña menos común';
        }

        return empty($this->failedRequirements);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        if (empty($this->failedRequirements)) {
            return 'La contraseña no cumple con los requisitos de seguridad.';
        }

        return 'La contraseña debe contener ' . implode(', ', $this->failedRequirements) . '.';
    }
}
