<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\LoginRequest;
use App\Http\Requests\Account\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Response\Success;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(protected AuthService $authService) {}

    /**
     * Registers a new user as a VOTER
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->registerUser($request->validated());

        return Success::make('User registered successfully.', new UserResource($user), 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->authenticate($request->email, $request->password);

        return Success::make('User logged in successfully.', ['token' => $token]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutUser($request->user());

        return Success::make('User logged out successfully.');
    }
}
