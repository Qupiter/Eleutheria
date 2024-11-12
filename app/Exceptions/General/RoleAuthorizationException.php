<?php

namespace App\Exceptions\General;

class RoleAuthorizationException extends BaseApiException
{
    protected $message = 'Insufficient permissions';
    protected static string $uuid = '05a1090e-1c72-44f4-9726-72f6e87c19d4';
    protected $code = 403;
}
