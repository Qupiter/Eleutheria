<?php

namespace App\Exceptions\Service\UserService;

use App\Exceptions\General\BaseApiException;

class UserAlreadyExistsException extends BaseApiException
{
    protected static string $uuid = '123e4567-e89b-12d3-a456-426614174001';
    protected $message = 'User already exists.';
    protected int $statusCode = 409;
}
