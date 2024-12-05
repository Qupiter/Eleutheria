<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="InternalServerError",
 *     type="object",
 *     description="Internal server error response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Internal Server Error"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="1d92c5d2-7dd4-4ea8-b922-278f946c1d1e"
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
class InternalServerErrorException extends BaseApiException
{
    protected $message = 'Internal Server Error';
    protected static string $uuid = '1d92c5d2-7dd4-4ea8-b922-278f946c1d1e';
    protected $code = 500;
}
