<?php

namespace App\Exceptions\General;

use Exception;

abstract class BaseApiException extends Exception
{
    protected static string $uuid = '1d92c5d2-7dd4-4ea8-b922-278f946c1d1e';

    /**
     * Get the UUID associated with the error.
     *
     * @return string
     */
    public static function getUuid(): string
    {
        return static::$uuid;
    }
}
