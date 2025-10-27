<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PreventSqlInjection
{
    protected $sqlPatterns = [
        '/(UNION\s+SELECT)/i',
        '/(SELECT\s+.*\s+FROM\s+.*\s+WHERE\s+.*=)/i',
        '/(INSERT\s+INTO\s+.*\s+VALUES\s*\()/i',
        '/(DROP\s+(TABLE|DATABASE))/i',
        '/(EXEC\s*\(|EXECUTE\s*\()/i',
        '/(\'\s*OR\s+\'1\'\s*=\s*\'1)/i',
        '/("\s*OR\s+"1"\s*=\s*"1)/i',
        '/(;\s*DROP\s+)/i',
    ];

    protected $skipFields = [
        'observations',
        'notes',
        'description',
        'content',
        'address',
        'message',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('X-Livewire') || $this->isAssetRequest($request)) {
            return $next($request);
        }

        $input = $request->all();

        if ($this->detectSqlInjection($input)) {
            Log::critical('SQL Injection attempt detected', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);

            abort(403, 'Solicitud sospechosa detectada.');
        }

        return $next($request);
    }

    protected function isAssetRequest(Request $request): bool
    {
        $path = $request->path();
        return str_starts_with($path, 'livewire/') || 
               str_starts_with($path, 'css/') || 
               str_starts_with($path, 'js/');
    }

    protected function detectSqlInjection(array $input): bool
    {
        foreach ($input as $key => $value) {
            if (in_array($key, $this->skipFields)) {
                continue;
            }

            if (is_array($value)) {
                if ($this->detectSqlInjection($value)) {
                    return true;
                }
            } elseif (is_string($value) && strlen($value) > 0) {
                foreach ($this->sqlPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
