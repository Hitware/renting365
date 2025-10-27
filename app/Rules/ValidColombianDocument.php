<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidColombianDocument implements Rule
{
    private string $documentType;

    /**
     * Create a new rule instance.
     */
    public function __construct(string $documentType)
    {
        $this->documentType = $documentType;
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        return match ($this->documentType) {
            'CC' => $this->validateCedulaCiudadania($value),
            'CE' => $this->validateCedulaExtranjeria($value),
            'TI' => $this->validateTarjetaIdentidad($value),
            'PAS' => $this->validatePasaporte($value),
            'NIT' => $this->validateNIT($value),
            default => false,
        };
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'El número de documento no es válido para el tipo seleccionado.';
    }

    /**
     * Validate Cédula de Ciudadanía.
     */
    private function validateCedulaCiudadania(string $value): bool
    {
        // Colombian CC: 6-10 digits
        return preg_match('/^\d{6,10}$/', $value);
    }

    /**
     * Validate Cédula de Extranjería.
     */
    private function validateCedulaExtranjeria(string $value): bool
    {
        // Colombian CE: 6-7 digits
        return preg_match('/^\d{6,7}$/', $value);
    }

    /**
     * Validate Tarjeta de Identidad.
     */
    private function validateTarjetaIdentidad(string $value): bool
    {
        // Colombian TI: 10-11 digits
        return preg_match('/^\d{10,11}$/', $value);
    }

    /**
     * Validate Passport.
     */
    private function validatePasaporte(string $value): bool
    {
        // Passport: Alphanumeric, 6-9 characters
        return preg_match('/^[A-Z0-9]{6,9}$/i', $value);
    }

    /**
     * Validate NIT with check digit.
     */
    private function validateNIT(string $value): bool
    {
        // Remove non-numeric characters
        $nit = preg_replace('/[^0-9]/', '', $value);

        // NIT must have 9-10 digits
        if (!preg_match('/^\d{9,10}$/', $nit)) {
            return false;
        }

        // Validate check digit for 10-digit NITs
        if (strlen($nit) === 10) {
            return $this->validateNITCheckDigit($nit);
        }

        return true;
    }

    /**
     * Validate NIT check digit.
     */
    private function validateNITCheckDigit(string $nit): bool
    {
        $multipliers = [71, 67, 59, 53, 47, 43, 41, 37, 29];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += (int)$nit[$i] * $multipliers[$i];
        }

        $remainder = $sum % 11;
        $checkDigit = $remainder > 1 ? 11 - $remainder : $remainder;

        return $checkDigit === (int)$nit[9];
    }
}
