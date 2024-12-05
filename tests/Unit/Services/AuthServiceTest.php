<?php

namespace Tests\Services;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    public function testAuthenticateSuccess(): void
    {
        $user = User::factory()->create([
            'email'    => 'johndoe@example.com',
            'password' => Hash::make('password123'),
        ]);

        $token = $this->authService->authenticate('johndoe@example.com', 'password123');

        $this->assertInstanceOf(NewAccessToken::class, $token);
        $this->assertEquals('voting-api-token-' . $user->id, $token->accessToken->name);
    }

    public function testAuthenticateFailsWithInvalidCredentials(): void
    {
        $this->expectException(ValidationException::class);

        User::factory()->create([
            'email'    => 'johndoe@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->authService->authenticate('johndoe@example.com', 'wrongpassword');
    }

    public function testAuthenticateFailsForNonExistentUser(): void
    {
        $this->expectException(ValidationException::class);

        $this->authService->authenticate('unknown@example.com', 'password123');
    }

    public function testRegisterUser(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe@example.com',
            'password'   => 'password123',
            'phone'      => '+1234567890',
        ];

        Role::create(['name' => UserRole::VOTER->value]);


        $user = $this->authService->registerUser($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertTrue($user->hasRole(UserRole::VOTER->value));
    }

    public function testLogoutUser(): void
    {
        $user = User::factory()->create();

        // Create some tokens for the user
        $user->createToken('token-1');
        $user->createToken('token-2');

        $this->assertCount(2, $user->tokens);

        $this->authService->logoutUser($user);

        $user->refresh();

        $this->assertCount(0, $user->tokens);
    }
}
