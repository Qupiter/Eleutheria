<?php

namespace App\Exceptions\General;

class MethodNotAllowedHttpException extends BaseApiException
{
    protected $message = 'HTTP method not allowed';
    protected static string $uuid = 'f63b9048-ee43-4b7a-9145-f43c4fca6a6e';
    protected $code = 405;
}
