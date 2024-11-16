<?php

namespace App\Exceptions\Service\UserService;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="UserAlreadyExists",
 *     type="object",
 *     description="User already exists response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="User already exists."
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="123e4567-e89b-12d3-a456-426614174001"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=409
 *         )
 *     )
 * )
 */
class UserAlreadyExistsException extends BaseApiException
{
    protected static string $uuid = '123e4567-e89b-12d3-a456-426614174001';
    protected $message = 'User already exists.';
    protected int $statusCode = 409;
}
