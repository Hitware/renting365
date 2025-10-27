<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SecurityException extends Exception
{
    public function render(Request $request): Response
    {
        return response()->view('errors.security', [
            'message' => $this->getMessage() ?: 'Solicitud sospechosa detectada.',
        ], 403);
    }

    public function report(): void
    {
        // Log security exception
    }
}
