<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoSqlInjection implements ValidationRule
{
    protected $patterns = [
        '/(\bUNION\b.*\bSELECT\b)/i',
        '/(\bSELECT\b.*\bFROM\b)/i',
        '/(\bINSERT\b.*\bINTO\b)/i',
        '/(\bUPDATE\b.*\bSET\b)/i',
        '/(\bDELETE\b.*\bFROM\b)/i',
        '/(\bDROP\b)/i',
        '/(\bEXEC\b)/i',
        '/(\'|\")(\s)*(OR|AND)(\s)*(\d+)(\s)*(=)/i',
        '/(\-\-|\#|\/\*)/i',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            return;
        }

        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                $fail('El campo :attribute contiene caracteres no permitidos.');
                return;
            }
        }
    }
}
