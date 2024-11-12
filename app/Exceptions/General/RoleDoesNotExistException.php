<?php

namespace App\Exceptions\General;

class RoleDoesNotExistException extends BaseApiException
{
    protected $message = 'Role not found';
    protected static string $uuid = '8d717bfc-f07a-44d7-8ed7-7c04f4b36785';
    protected $code = 404;
}
