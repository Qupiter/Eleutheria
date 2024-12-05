<?php

namespace App\Exceptions\Service\UserService;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="UserAlreadyHasThisRole",
 *     type="object",
 *     description="User already has this role response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="User already has this role."
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="41a6dd12-d4cb-483c-a072-a92561ebff50"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=400
 *         )
 *     )
 * )
 */
class UserAlreadyHasThisRoleException extends BaseApiException
{
    protected static string $uuid = '41a6dd12-d4cb-483c-a072-a92561ebff50';
    protected $message = 'User already has this role.';
    protected int $statusCode = 400;
}
