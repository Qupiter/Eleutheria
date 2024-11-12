<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

interface ResponseInterface
{
    public static function make(): JsonResponse;
}
