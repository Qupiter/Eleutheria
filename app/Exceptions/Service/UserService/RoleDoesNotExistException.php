<?php

namespace App\Exceptions\Service\UserService;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="RoleNotFound",
 *     type="object",
 *     description="Role not found response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Role not found"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="8d717bfc-f07a-44d7-8ed7-7c04f4b36785"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=404
 *         )
 *     )
 * )
 */
class RoleDoesNotExistException extends BaseApiException
{
    protected $message = 'Role not found';
    protected static string $uuid = '8d717bfc-f07a-44d7-8ed7-7c04f4b36785';
    protected $code = 404;
}
