<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    protected $except = [
        'password',
        'password_confirmation',
        'current_password',
        'observations',
        'notes',
        'description',
        'content',
        'address',
        'message',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Skip sanitization for Livewire requests
        if ($request->header('X-Livewire')) {
            return $next($request);
        }

        $input = $request->all();
        
        array_walk_recursive($input, function (&$value, $key) {
            if (!in_array($key, $this->except) && is_string($value)) {
                $value = $this->sanitize($value);
            }
        });

        $request->merge($input);

        return $next($request);
    }

    protected function sanitize(string $value): string
    {
        // Remove null bytes
        $value = str_replace(chr(0), '', $value);
        
        // Only remove dangerous tags, keep basic formatting
        $value = strip_tags($value, '<b><i><u><strong><em><br><p><span>');
        
        return trim($value);
    }
}
