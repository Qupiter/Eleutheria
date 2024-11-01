<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e): JsonResponse|Response
    {
        $data = [
            'success' => false,
            'message' => $e->getMessage(),
            'status'  => $this->getStatusCode($e),
        ];

        if ($errors = $this->getErrors($e)) {
            $data['errors'] = $errors;
        }

        if ($request->expectsJson()) {
            return response()->json($data, $this->getStatusCode($e));
        }

        return parent::render($request, $e);
    }

    /**
     * Determine the HTTP status code for the exception.
     */
    protected function getStatusCode(Throwable $exception): int
    {
        return method_exists($exception, 'getStatusCode')
            ? $exception->getStatusCode()
            : 500;
    }

    protected function getErrors(Throwable $exception): ?array
    {
        return method_exists($exception, 'errors')
            ? $exception->errors()
            : null;
    }
}
