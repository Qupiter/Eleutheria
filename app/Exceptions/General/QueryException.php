<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="DatabaseError",
 *     type="object",
 *     description="Database error response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Database error. Please try again later."
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="48bf3b4f-cf05-4885-8244-8dc941d251eb"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=500
 *         )
 *     )
 * )
 */
class QueryException extends BaseApiException
{
    protected $message = 'Database error. Please try again later.';
    protected static string $uuid = '48bf3b4f-cf05-4885-8244-8dc941d251eb';
    protected $code = 500;
}
