<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="FailureResponse",
 *     type="object",
 *     description="Generic failure response",
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the response",
 *         example="fail"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Error message describing the failure",
 *         example="An error occurred while processing the request."
 *     ),
 *     @OA\Property(
 *         property="uuid",
 *         type="string",
 *         format="uuid",
 *         description="Unique identifier for the error instance",
 *         example="123e4567-e89b-12d3-a456-426614174000"
 *     ),
 *     @OA\Property(
 *         property="errors",
 *         type="array",
 *         description="Detailed list of errors, if available",
 *         @OA\Items(type="object", example={"field": "error description"})
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         description="Metadata related to the response",
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code representing the error",
 *             example=400
 *         ),
 *         @OA\Property(
 *             property="timestamp",
 *             type="string",
 *             format="date-time",
 *             description="The timestamp when the error occurred",
 *             example="2023-01-01T12:00:00+00:00"
 *         )
 *     )
 * )
 */
class FailureSchema
{

}
