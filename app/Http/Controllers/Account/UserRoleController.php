<?php

namespace App\Http\Controllers\Account;

use App\Exceptions\Service\UserService\UserAlreadyHasThisRoleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserRoleRequest;
use App\Http\Response\Success;
use App\Models\Account\User;
use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    /**
     * @param UserService $userService
     * @param UserRoleService $userRoleService
     */
    public function __construct(
        protected UserService $userService,
        protected UserRoleService $userRoleService
    ) {}

    /**
     * @param int|null $id
     * @return JsonResponse
     */
    public function index(?int $id = null): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if($id) $user = $this->userService->getUserById($id);

        $roles = $user->getRoleNames();

        return Success::make('User roles:', $roles->all());
    }

    /**
     * @param UserRoleRequest $request
     * @return JsonResponse
     * @throws UserAlreadyHasThisRoleException
     */
    public function assign(UserRoleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $this->userRoleService->assign($validated['userId'], $validated['roleName']);

        $updatedRoles = $user->getRoleNames();

        return Success::make('User roles:', $updatedRoles->all());
    }

    /**
     * @param UserRoleRequest $request
     * @return JsonResponse
     */
    public function remove(UserRoleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $this->userRoleService->remove($validated['userId'], $validated['roleName']);

        $updatedRoles = $user->getRoleNames();

        return Success::make('User roles:', $updatedRoles->all());
    }
}
