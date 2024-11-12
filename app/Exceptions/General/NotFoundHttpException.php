<?php

namespace App\Exceptions\General;

class NotFoundHttpException extends BaseApiException
{
    protected $message = 'Endpoint not found';
    protected static string $uuid = '9662e84f-9bef-4669-913e-be2a6f0a3ea2';
    protected $code = 404;
}
