<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Log specific routes or actions
        if ($this->shouldLog($request)) {
            $this->logRequest($request, $response);
        }

        return $response;
    }

    /**
     * Determine if the request should be logged.
     */
    private function shouldLog(Request $request): bool
    {
        // Log only authenticated requests
        if (!auth()->check()) {
            return false;
        }

        // Don't log GET requests (only mutations)
        if ($request->isMethod('get')) {
            return false;
        }

        // Don't log health check and monitoring endpoints
        $excludedPaths = [
            'api/health',
            'api/ping',
            '_debugbar',
        ];

        foreach ($excludedPaths as $path) {
            if (str_starts_with($request->path(), $path)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Log the request.
     */
    private function logRequest(Request $request, Response $response): void
    {
        $action = $this->determineAction($request);
        $module = $this->determineModule($request);

        ActivityLog::log($action, $module, auth()->user(), [
            'method' => $request->method(),
            'path' => $request->path(),
            'status_code' => $response->getStatusCode(),
            'input' => $this->sanitizeInput($request->except(['password', 'password_confirmation', '_token'])),
        ]);
    }

    /**
     * Determine the action from the request.
     */
    private function determineAction(Request $request): string
    {
        $method = $request->method();
        $path = $request->path();

        // Try to determine action from route name
        if ($request->route()) {
            $routeName = $request->route()->getName();
            if ($routeName) {
                return str_replace('.', '_', $routeName);
            }
        }

        // Fallback to method + path
        return strtolower($method) . '.' . str_replace('/', '.', $path);
    }

    /**
     * Determine the module from the request.
     */
    private function determineModule(Request $request): string
    {
        $path = $request->path();
        $segments = explode('/', $path);

        // Return first segment as module (e.g., 'users', 'admin', 'api')
        return $segments[0] ?? 'general';
    }

    /**
     * Sanitize input data for logging.
     */
    private function sanitizeInput(array $input): array
    {
        // Remove sensitive fields
        $sensitiveFields = ['password', 'token', 'secret', 'api_key', 'credit_card'];

        foreach ($sensitiveFields as $field) {
            if (isset($input[$field])) {
                $input[$field] = '[REDACTED]';
            }
        }

        return $input;
    }
}
