<?php

namespace Tests\Unit\Http\Controllers\Account;

use App\Http\Controllers\Account\AuthController;
use App\Http\Requests\Account\LoginRequest;
use App\Http\Requests\Account\RegisterRequest;
use App\Models\Account\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;
use Mockery;

class AuthControllerTest extends TestCase
{
    private Mockery\MockInterface $authService;
    private AuthController $authController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authService    = Mockery::mock(AuthService::class);
        $this->authController = new AuthController($this->authService);
    }

    public function test_register_user_successfully()
    {
        $userData = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'john.doe@example.com',
            'password'   => 'securepassword',
            'phone'      => '1234567891',
        ];
        $newUser  = new User($userData);

        $request = Mockery::mock(RegisterRequest::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($userData);

        $this->authService->shouldReceive('registerUser')
            ->once()
            ->with($userData)
            ->andReturn($newUser);

        $response = $this->authController->register($request);

        $responseData = $response->getData(true);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('User registered successfully.', $responseData['message']);
        $this->assertEquals($newUser->first_name, $responseData['data']['first_name']);
    }

    public function test_login_user_successfully()
    {
        $email = 'john.doe@example.com';
        $password = 'securepassword';

        $request = Mockery::mock(LoginRequest::class);
        $request->email = $email;
        $request->password = $password;

        $mockToken = new NewAccessToken(
            Mockery::mock(PersonalAccessToken::class),
            'test_refresh_token'
        );

        $this->authService->shouldReceive('authenticate')
            ->once()
            ->with($email, $password)
            ->andReturn($mockToken);

        $response = $this->authController->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User logged in successfully.', $responseData['message']);
        $this->assertEquals($mockToken->plainTextToken, $responseData['data']['token']);
    }

    public function test_logout_user_successfully()
    {
        $mockUser = Mockery::mock(User::class);
        $mockUser->shouldReceive('getAttribute')->with('id')->andReturn(1);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($mockUser);

        $this->authService->shouldReceive('logoutUser')
            ->once()
            ->with($mockUser);

        $response = $this->authController->logout();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals('User logged out successfully.', $responseData['message']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
