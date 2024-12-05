<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="MethodNotAllowed",
 *     type="object",
 *     description="HTTP method not allowed response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="HTTP method not allowed"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="f63b9048-ee43-4b7a-9145-f43c4fca6a6e"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=405
 *         )
 *     )
 * )
 */
class MethodNotAllowedHttpException extends BaseApiException
{
    protected $message = 'HTTP method not allowed';
    protected static string $uuid = 'f63b9048-ee43-4b7a-9145-f43c4fca6a6e';
    protected $code = 405;
}
