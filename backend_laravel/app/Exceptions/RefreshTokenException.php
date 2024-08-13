<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class RefreshTokenException extends Exception
{
    /**
     * Report the exception.
     */
    public function report()
    {
        // Log the error or do something specific when this exception occurs
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request)
    {
        return response()->json([
            'error' => 'Refresh token is invalid or has expired.',
            'message' => $this->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }
}
