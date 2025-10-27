<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only require phone verification if user has a phone number
        if ($user->phone && !$user->hasVerifiedPhone()) {
            return redirect()->route('verification.phone')
                ->with('warning', 'Debes verificar tu número de teléfono antes de continuar.');
        }

        return $next($request);
    }
}
