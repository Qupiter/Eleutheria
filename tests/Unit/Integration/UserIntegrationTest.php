<?php

namespace Tests\Integration;


use App\Models\Account\User;
use App\Models\Account\UserRole;
use App\Services\AuthService;
use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private UserService $userService;
    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = app(UserService::class);
        $this->authService = app(AuthService::class);
    }

    public function testUserRegistrationAndLogin(): void
    {
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'phone' => '+1234567890',
        ];

        Role::create(['name' => UserRole::VOTER]);

        // Register user
        $user = $this->userService->createUser($userData);
        $this->assertTrue($user->hasRole(UserRole::VOTER));

        // Authenticate user
        $token = $this->authService->authenticate('johndoe@example.com', 'password123');
        $this->assertNotNull($token);
        $this->assertEquals('voting-api-token-' . $user->id, $token->accessToken->name);
    }

    public function testAssignRoleToUser(): void
    {
        $user = User::factory()->create();

        Role::create(['name' => UserRole::ADMIN->value]);
        Role::create(['name' => UserRole::VOTER->value]);

        $userRoleService = app(UserRoleService::class);

        $user = $userRoleService->assign($user->id, UserRole::ADMIN->value);
        $this->assertTrue($user->hasRole(UserRole::ADMIN->value));
    }

    public function testUpdateUserInformation(): void
    {
        $user = User::factory()->create();
        Role::create(['name' => UserRole::VOTER->value]);

        $updatedData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'password' => 'newpassword123',
        ];

        $updatedUser = $this->userService->updateUser($user->id, $updatedData);

        $this->assertEquals('Jane', $updatedUser->first_name);
        $this->assertTrue(Hash::check('newpassword123', $updatedUser->password));
    }

    public function testSoftDeleteUser(): void
    {
        $user = User::factory()->create();
        Role::create(['name' => UserRole::VOTER]);

        $deletedUser = $this->userService->softDeleteUser($user->id);

        $this->assertSoftDeleted($deletedUser);
    }

    public function testHardDeleteUser(): void
    {
        $user = User::factory()->create();
        Role::create(['name' => UserRole::VOTER]);

        $this->userService->softDeleteUser($user->id);
        $this->userService->hardDeleteUser($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
