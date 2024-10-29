<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->registerUser($request->validated());

        return $this->successResponse('User registered successfully.', $user->toArray(), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->authenticate($request->email, $request->password);

        return $this->successResponse('User logged in successfully.', ['token' => $token]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutUser($request->user());
        return $this->successResponse('User logged in successfully.');
    }
}
