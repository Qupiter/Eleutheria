<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseApiException;

/**
 * @OA\Schema(
 *     schema="ValidationFailure",
 *     type="object",
 *     description="Validation failure response",
 *     @OA\Property(
 *         property="error",
 *         type="object",
 *         description="Error details",
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             description="Error message",
 *             example="Validation failed"
 *         ),
 *         @OA\Property(
 *             property="uuid",
 *             type="string",
 *             format="uuid",
 *             description="Unique identifier for the error instance",
 *             example="ee4f70cd-9d01-4f8d-9f89-5c24492c1c6a"
 *         ),
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code of the error",
 *             example=422
 *         ),
 *         @OA\Property(
 *             property="details",
 *             type="object",
 *             description="Detailed validation errors",
 *             additionalProperties=@OA\Schema(
 *                 type="array",
 *                 @OA\Items(
 *                     type="string",
 *                     example="The field_name is required."
 *                 )
 *             ),
 *             example={
 *                 "field_name": {
 *                     "The field_name is required.",
 *                     "The field_name must be a string."
 *                 }
 *             }
 *         )
 *     )
 * )
 */
class ValidationException extends BaseApiException
{
    protected $message = 'Validation failed';
    protected static string $uuid = 'ee4f70cd-9d01-4f8d-9f89-5c24492c1c6a';
    protected $code = 422;

    public function __construct(private readonly array $errors = [])
    {
        parent::__construct($this->message, $this->code);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
