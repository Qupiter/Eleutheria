<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TokenResource",
 *     type="object",
 *     description="Resource representing an authentication token",
 *     @OA\Property(
 *         property="token",
 *         type="string",
 *         description="The authentication token",
 *         example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
 *     )
 * )
 */
class TokenResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'token' => $this->plainTextToken
        ];
    }
}
