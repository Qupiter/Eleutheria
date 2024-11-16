<?php

namespace App\Swagger\Docs;

/**
 * @OA\Get(
 *     path="/api/v1/users",
 *     summary="Display a listing of users",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="A list of users",
 *         @OA\JsonContent(ref="#/components/schemas/UserCollection")
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Insufficient permissions",
 *         @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/v1/users",
 *     summary="Store a newly created user",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/UserResource")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ValidationFailure")
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Insufficient permissions",
 *         @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/v1/users/{id}",
 *     summary="Display the specified user",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the user to retrieve",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User retrieved successfully",
 *         @OA\JsonContent(ref="#/components/schemas/UserResource")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found",
 *         @OA\JsonContent(ref="#/components/schemas/ResourceNotFound")
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Insufficient permissions",
 *         @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/v1/users/{id}",
 *     summary="Update the specified user",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the user to update",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/UserResource")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found",
 *         @OA\JsonContent(ref="#/components/schemas/ResourceNotFound")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ValidationFailure")
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Insufficient permissions",
 *         @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/v1/users/{id}",
 *     summary="Soft delete a user",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the user to delete",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deactivated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/UserResource")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found",
 *         @OA\JsonContent(ref="#/components/schemas/ResourceNotFound")
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Insufficient permissions",
 *         @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *     ),
 * )
 *
 * @OA\Delete(
 *      path="/api/v1/users/deactivate/{id}",
 *      summary="Soft delete a user",
 *      tags={"Users"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="User deactivated successfully",
 *          @OA\JsonContent(ref="#/components/schemas/UserResource")
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Resource not found",
 *          @OA\JsonContent(ref="#/components/schemas/ResourceNotFound")
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Insufficient permissions",
 *          @OA\JsonContent(ref="#/components/schemas/RoleAuthorizationFailure")
 *      ),
 *  )
 */
class UserControllerDocs
{

}
