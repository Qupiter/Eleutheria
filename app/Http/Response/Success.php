<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class Success implements ResponseInterface
{
    public static final function make(string $message = 'Success', mixed $data = [], int $code = 200): JsonResponse
    {
        if ($data instanceof JsonResource) {
            $data = $data->toArray(request());
        }

        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
            'meta'    => [
                'code'      => $code,
                'timestamp' => now()->toIso8601String()
            ]
        ], $code);
    }
}
