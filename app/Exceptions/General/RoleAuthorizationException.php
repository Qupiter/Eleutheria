<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="RoleAuthorizationFailure",
 *     type="object",
 *     description="Insufficient permissions response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Insufficient permissions"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="05a1090e-1c72-44f4-9726-72f6e87c19d4"
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
class RoleAuthorizationException extends BaseApiException
{
    protected $message = 'Insufficient permissions';
    protected static string $uuid = '05a1090e-1c72-44f4-9726-72f6e87c19d4';
    protected $code = 403;
}
