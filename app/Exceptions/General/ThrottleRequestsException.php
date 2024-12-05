<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="ThrottleRequests",
 *     type="object",
 *     description="Too many requests response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Too many requests. Please slow down."
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="f4f45da9-6b5f-4818-9a3a-0c84d2de68e2"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=429
 *         )
 *     )
 * )
 */
class ThrottleRequestsException extends BaseApiException
{
    protected $message = 'Too many requests. Please slow down.';
    protected static string $uuid = 'f4f45da9-6b5f-4818-9a3a-0c84d2de68e2';
    protected $code = 429;
}
