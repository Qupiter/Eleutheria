<?php

namespace App\Exceptions\General;

class QueryException extends BaseApiException
{
    protected $message = 'Database error. Please try again later.';
    protected static string $uuid = '48bf3b4f-cf05-4885-8244-8dc941d251eb';
    protected $code = 500;
}
