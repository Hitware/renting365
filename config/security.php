<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SQL Injection Protection
    |--------------------------------------------------------------------------
    */
    'sql_injection' => [
        'enabled' => env('SQL_INJECTION_PROTECTION', true),
        'log_attempts' => env('LOG_SQL_INJECTION_ATTEMPTS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limiting' => [
        'enabled' => env('RATE_LIMITING_ENABLED', true),
        'max_attempts' => env('RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('RATE_LIMIT_DECAY_MINUTES', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | IP Blocking
    |--------------------------------------------------------------------------
    */
    'ip_blocking' => [
        'enabled' => env('IP_BLOCKING_ENABLED', true),
        'max_failed_attempts' => env('IP_BLOCK_MAX_ATTEMPTS', 5),
        'block_duration' => env('IP_BLOCK_DURATION', 3600), // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Input Sanitization
    |--------------------------------------------------------------------------
    */
    'sanitization' => [
        'enabled' => env('INPUT_SANITIZATION_ENABLED', true),
        'except_fields' => [
            'password',
            'password_confirmation',
            'current_password',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    */
    'headers' => [
        'enabled' => env('SECURITY_HEADERS_ENABLED', true),
        'hsts_max_age' => env('HSTS_MAX_AGE', 31536000),
    ],

];
