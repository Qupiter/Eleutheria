<?php

namespace App\Swagger\Docs;

/**
 * @OA\Get(
 *     path="/api/v1/account/roles/{userId?}",
 *     summary="List roles of the authenticated user or passed user id",
 *     tags={"User Roles"},
 *     @OA\Response(
 *         response=200,
 *         description="List of roles for the authenticated user",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(type="string", example="Admin")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ResourceNotFound")
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/v1/account/roles/assign",
 *     summary="Assign a role to a user",
 *     tags={"User Roles"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserRoleRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Roles updated successfully",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(type="string", example="Admin")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="User already has this role",
 *         @OA\JsonContent(ref="#/components/schemas/ValidationFailure")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ResourceNotFound")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/v1/account/roles/remove",
 *     summary="Remove a role from a user",
 *     tags={"User Roles"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserRoleRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Roles updated successfully",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(type="string", example="Admin")
 *         )
 *     ),
 *     @OA\Response(
 *          response=400,
 *          description="User already has this role",
 *          @OA\JsonContent(ref="#/components/schemas/ValidationFailure")
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(ref="#/components/schemas/ResourceNotFound")
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *          @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *      )
 * )
 */
class UserRoleControllerDocs {}
