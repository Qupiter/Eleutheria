<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait ApiResponseTrait
{
    protected function successResponse(
        string $message = "Action completed successfully.",
        array $data = [],
        $code = 200
    ): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "data"   => [
                "message" => $message,
                "result"  => $data
            ],
            "meta"   => [
                "code"      => $code,
                "timestamp" => now()->toIso8601String()
            ]
        ], $code);
    }

    protected function errorResponse(\Exception $exception, $code = 500): JsonResponse
    {
        $message   = $exception->getMessage();
        $errorCode = method_exists($exception, 'getCode') ? $exception->getCode() : "INTERNAL_ERROR";

        $details = [];
        if ($exception instanceof ValidationException) {
            $code      = 422;                   // HTTP status for unprocessable entity
            $details   = $exception->errors();  // Get validation errors
            $errorCode = "VALIDATION_ERROR";
        }

        return response()->json([
            "status" => "error",
            "error"  => [
                "message" => $message,
                "details" => $details,
                "code"    => $errorCode
            ],
            "meta"   => [
                "code"      => $code,
                "timestamp" => now()->toIso8601String()
            ]
        ], $code);
    }
}
