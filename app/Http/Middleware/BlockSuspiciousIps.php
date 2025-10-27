<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BlockSuspiciousIps
{
    protected $maxFailedAttempts = 5;
    protected $blockDuration = 3600; // 1 hour

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $key = 'blocked_ip:' . $ip;

        if (Cache::has($key)) {
            Log::warning('Blocked IP attempted access', ['ip' => $ip]);
            abort(403, 'Su dirección IP ha sido bloqueada temporalmente.');
        }

        return $next($request);
    }

    public static function recordFailedAttempt(string $ip): void
    {
        $key = 'failed_attempts:' . $ip;
        $attempts = Cache::get($key, 0) + 1;

        Cache::put($key, $attempts, now()->addMinutes(15));

        if ($attempts >= (new self())->maxFailedAttempts) {
            Cache::put('blocked_ip:' . $ip, true, (new self())->blockDuration);
            
            Log::alert('IP blocked due to suspicious activity', [
                'ip' => $ip,
                'attempts' => $attempts,
            ]);
        }
    }

    public static function clearFailedAttempts(string $ip): void
    {
        Cache::forget('failed_attempts:' . $ip);
    }
}
