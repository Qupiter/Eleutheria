<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     schema="UserCollection",
 *     type="object",
 *     description="Collection of user resources",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         description="Array of user resources",
 *         @OA\Items(ref="#/components/schemas/UserResource")
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         description="Pagination details",
 *         @OA\Property(
 *             property="current_page",
 *             type="integer",
 *             description="Current page number",
 *             example=1
 *         ),
 *         @OA\Property(
 *             property="last_page",
 *             type="integer",
 *             description="Last page number",
 *             example=10
 *         ),
 *         @OA\Property(
 *             property="per_page",
 *             type="integer",
 *             description="Number of items per page",
 *             example=15
 *         ),
 *         @OA\Property(
 *             property="total",
 *             type="integer",
 *             description="Total number of items",
 *             example=150
 *         )
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         description="Pagination links",
 *         @OA\Property(
 *             property="first",
 *             type="string",
 *             description="URL to the first page",
 *             example="http://api.example.com/api/v1/account/users?page=1"
 *         ),
 *         @OA\Property(
 *             property="last",
 *             type="string",
 *             description="URL to the last page",
 *             example="http://api.example.com/api/v1/account/users?page=10"
 *         ),
 *         @OA\Property(
 *             property="prev",
 *             type="string",
 *             description="URL to the previous page",
 *             nullable=true,
 *             example="http://api.example.com/api/v1/account/users?page=1"
 *         ),
 *         @OA\Property(
 *             property="next",
 *             type="string",
 *             description="URL to the next page",
 *             nullable=true,
 *             example="http://api.example.com/api/v1/account/users?page=2"
 *         )
 *     )
 * )
 */
class UserCollection extends ResourceCollection
{
}
