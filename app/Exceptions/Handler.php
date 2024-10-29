<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors'  => $e->errors() ?? [],
                'status'  => $this->getStatusCode($e),
            ], $this->getStatusCode($e));
        }

        return parent::render($request, $e);
    }

    /**
     * Determine the HTTP status code for the exception.
     */
    protected function getStatusCode(Throwable $exception)
    {
        return method_exists($exception, 'getStatusCode')
            ? $exception->getStatusCode()
            : 500;
    }
}
