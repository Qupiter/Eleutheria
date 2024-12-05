<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="AuthorizationFailure",
 *     type="object",
 *     description="Authorization failure response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Forbidden"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="d6ecefb8-732f-4633-8f5b-e68bae10e58a"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=403
 *         )
 *     )
 * )
 */
class AuthorizationException extends BaseApiException
{
    protected $message = 'Forbidden';
    protected static string $uuid = 'd6ecefb8-732f-4633-8f5b-e68bae10e58a';
    protected $code = 403;
}
