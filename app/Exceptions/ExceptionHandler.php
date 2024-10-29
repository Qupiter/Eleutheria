<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class ExceptionHandler
{
    public static function render($request, Exception $exception): ?JsonResponse
    {
        // Check if the request expects a JSON response
        if ($request->expectsJson()) {
            // Handle specific exceptions
            if ($exception instanceof ValidationException) {
                return new JsonResponse([
                    'error' => 'Validation Error',
                    'messages' => $exception->validator->errors(),
                ], 422);
            }

            // Handle other exceptions generically
            return new JsonResponse([
                'error' => 'Server Error',
                'message' => $exception->getMessage(),
            ], 500); // You can adjust the status code based on the exception type
        }

        // For non-JSON requests, fall back to default behavior
        return null; // This allows the framework to continue with default error handling
    }
}
