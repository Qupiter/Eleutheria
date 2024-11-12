<?php

namespace App\Exceptions\General;

class ModelNotFoundException extends BaseApiException
{
    protected $message = 'Resource not found';
    protected static string $uuid = '973f9dc7-ae2c-4bac-b053-1927cb5d9c13';
    protected $code = 404;
}
