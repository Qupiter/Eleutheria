<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="ResourceNotFound",
 *     type="object",
 *     description="Resource not found response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Resource not found"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="973f9dc7-ae2c-4bac-b053-1927cb5d9c13"
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
class ModelNotFoundException extends BaseApiException
{
    protected $message = 'Resource not found';
    protected static string $uuid = '973f9dc7-ae2c-4bac-b053-1927cb5d9c13';
    protected $code = 404;
}
