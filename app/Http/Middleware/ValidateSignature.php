<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidateSignature
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->hasInvalidSignature($request)) {
            Log::warning('Invalid request signature detected', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);

            abort(403, 'Firma de solicitud inválida.');
        }

        return $next($request);
    }

    protected function hasInvalidSignature(Request $request): bool
    {
        if (!$request->hasValidSignature()) {
            return true;
        }

        return false;
    }
}
