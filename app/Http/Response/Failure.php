<?php

namespace App\Http\Response;

use App\Exceptions\BaseApiException;
use Illuminate\Http\JsonResponse;

class Failure implements ResponseInterface
{
    /**
     * Convert the Failure static properties to an associative array.
     *
     * @param BaseApiException|null $exception
     * @return JsonResponse
     */
    public static final function make(?BaseApiException $exception = null): JsonResponse
    {
        return response()->json([
            'status'  => 'fail',
            'message' => $exception->getMessage(),
            'uuid'    => $exception->getUuid(),
            'errors'  => self::getErrors($exception) ?? [],
            'meta'    => [
                'code'      => $exception->getCode(),
                'timestamp' => now()->toIso8601String()
            ]
        ], $exception->getCode());
    }

    private static function getErrors(BaseApiException $exception): ?array
    {
        return method_exists($exception, 'getErrors')
            ? $exception->getErrors()
            : null;
    }
}
