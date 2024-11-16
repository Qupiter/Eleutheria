<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\StoreUserRequest;
use App\Http\Requests\Account\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Response\Success;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService) {}

    /**
     * Display a listing of users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return Success::make('Users list:', new UserCollection($users));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $newUser = $this->userService->createUser($request->validated());

        return Success::make('User created successfully.', new UserResource($newUser), 201);
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        return Success::make('User is:', new UserResource($user));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UpdateUserRequest $request
     * @param int               $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $updatedUser = $this->userService->updateUser($id, $request->validated());

        return Success::make('User updated successfully.', new UserResource($updatedUser));
    }

    /**
     * Soft delete a user.
     *
     * @param int  $id
     * @return JsonResponse
     */
    public function discard(int $id): JsonResponse
    {
        $deactivatedUser = $this->userService->softDeleteUser($id);

        return Success::make('User deactivated successfully.', new UserResource($deactivatedUser));
    }

    /**
     * Hard delete a user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userService->hardDeleteUser($id);

        return Success::make('User deleted successfully.');
    }
}
