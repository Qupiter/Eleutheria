<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function getUserRoles(): JsonResponse
    {
        $user = Auth::user();

        /** @var Collection $roles */
        if (!$roles = $user->getRoleNames()) {
            return $this->errorResponse(new \Exception('User has no Roles'), 400);
        }

        return $this->successResponse('User roles are: ', $roles->all());
    }
}
