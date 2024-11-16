<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="AuthenticationFailure",
 *     type="object",
 *     description="Authentication failure response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Unauthorized"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="8c921657-8418-4236-bb03-9e02b5396ca9"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=401
 *         )
 *     )
 * )
 */
class AuthenticationException extends BaseApiException
{
    protected $message = 'Unauthorized';
    protected static string $uuid = '8c921657-8418-4236-bb03-9e02b5396ca9';
    protected $code = 401;
}
