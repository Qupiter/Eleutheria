<?php

namespace App\Exceptions\Service\UserService;

use App\Exceptions\General\BaseApiException;

class UserAlreadyHasThisRoleException extends BaseApiException
{
    protected static string $uuid = '41a6dd12-d4cb-483c-a072-a92561ebff50';
    protected $message = 'User already has this role.';
    protected int $statusCode = 400;
}
