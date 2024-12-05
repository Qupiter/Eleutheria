<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="EndpointNotFound",
 *     type="object",
 *     description="Endpoint not found response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Endpoint not found"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="9662e84f-9bef-4669-913e-be2a6f0a3ea2"
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
class NotFoundHttpException extends BaseApiException
{
    protected $message = 'Endpoint not found';
    protected static string $uuid = '9662e84f-9bef-4669-913e-be2a6f0a3ea2';
    protected $code = 404;
}
