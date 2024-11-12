<?php

namespace App\Exceptions\General;

class AuthorizationException extends BaseApiException
{
    protected $message = 'Forbidden';
    protected static string $uuid = 'd6ecefb8-732f-4633-8f5b-e68bae10e58a';
    protected $code = 403;
}
