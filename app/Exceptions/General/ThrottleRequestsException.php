<?php

namespace App\Exceptions\General;

class ThrottleRequestsException extends BaseApiException
{
    protected $message = 'Too many requests. Please slow down.';
    protected static string $uuid = 'f4f45da9-6b5f-4818-9a3a-0c84d2de68e2';
    protected $code = 429;
}
