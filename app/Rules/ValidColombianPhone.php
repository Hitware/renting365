<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidColombianPhone implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        // Remove spaces, dashes, and parentheses
        $phone = preg_replace('/[\s\-()]/', '', $value);

        // Colombian phone formats:
        // Mobile: 10 digits starting with 3 (e.g., 3001234567)
        // Landline: 7 digits for cities (e.g., 6012345678 with area code)
        // International format: +57 followed by 10 digits

        // Check for international format
        if (preg_match('/^\+57[0-9]{10}$/', $phone)) {
            return true;
        }

        // Check for mobile (10 digits starting with 3)
        if (preg_match('/^3[0-9]{9}$/', $phone)) {
            return true;
        }

        // Check for landline with area code (10 digits starting with 6 or other area codes)
        if (preg_match('/^[1-9][0-9]{9}$/', $phone)) {
            return true;
        }

        // Check for 7-digit landline
        if (preg_match('/^[0-9]{7}$/', $phone)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'El número de teléfono no es válido. Use el formato colombiano (ej: 3001234567 o +573001234567).';
    }
}
