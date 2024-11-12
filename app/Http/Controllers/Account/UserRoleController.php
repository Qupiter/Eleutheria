<?php

namespace App\Http\Controllers\Account;

use App\Exceptions\Service\UserService\UserAlreadyHasThisRoleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserRoleRequest;
use App\Http\Response\Failure;
use App\Http\Response\Success;
use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    /**
     * @param UserRoleService $userRoleService
     */
    public function __construct(protected UserRoleService $userRoleService) {}

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** @var Collection $roles */
        $roles = Auth::user()->getRoleNames();

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
