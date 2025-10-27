<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SafeString implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            return;
        }

        // Check for null bytes
        if (strpos($value, "\0") !== false) {
            $fail('El campo :attribute contiene caracteres inválidos.');
            return;
        }

        // Check for script tags
        if (preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $value)) {
            $fail('El campo :attribute contiene contenido no permitido.');
            return;
        }

        // Check for dangerous HTML
        if (preg_match('/<(iframe|object|embed|applet)/i', $value)) {
            $fail('El campo :attribute contiene etiquetas no permitidas.');
            return;
        }
    }
}
