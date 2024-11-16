<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="SuccessResponse",
 *     type="object",
 *     description="Generic success response",
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the response",
 *         example="success"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="A success message",
 *         example="Operation completed successfully."
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         description="The data returned with the response, if any",
 *         example={
 *             "id": 1,
 *             "name": "Sample Item"
 *         }
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         description="Metadata related to the response",
 *         @OA\Property(
 *             property="code",
 *             type="integer",
 *             description="HTTP status code",
 *             example=200
 *         ),
 *         @OA\Property(
 *             property="timestamp",
 *             type="string",
 *             format="date-time",
 *             description="The timestamp when the response was generated",
 *             example="2023-01-01T12:00:00+00:00"
 *         )
 *     )
 * )
 */
class SuccessSchema
{

}
