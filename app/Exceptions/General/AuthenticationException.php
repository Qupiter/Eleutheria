<?php

namespace App\Exceptions\General;

class AuthenticationException extends BaseApiException
{
    protected $message = 'Unauthorized';
    protected static string $uuid = '8c921657-8418-4236-bb03-9e02b5396ca9';
    protected $code = 401;
}
