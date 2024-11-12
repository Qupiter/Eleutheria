<?php

namespace App\Exceptions\General;

class InternalServerErrorException extends BaseApiException
{
    protected $message = 'Internal Server Error';
    protected static string $uuid = '1d92c5d2-7dd4-4ea8-b922-278f946c1d1e';
    protected $code = 500;
}
