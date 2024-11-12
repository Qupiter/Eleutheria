<?php

namespace App\Exceptions\General;

class ValidationException extends BaseApiException
{
    protected $message = 'Validation failed';
    protected static string $uuid = 'ee4f70cd-9d01-4f8d-9f89-5c24492c1c6a';
    protected $code = 422;

    public function __construct(private readonly array $errors = [])
    {
        parent::__construct($this->message, $this->code);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
