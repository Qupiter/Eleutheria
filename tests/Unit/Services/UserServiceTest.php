<?php

namespace Tests\Services;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    public function testCreateUser(): void
    {
        $userData = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe@example.com',
            'password'   => 'password123',
            'phone'      => '+1234567890',
        ];
        Role::create(['name' => UserRole::VOTER->value]);

        $user = $this->userService->createUser($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertTrue($user->hasRole(UserRole::VOTER->value));
    }

    public function testGetAllUsers(): void
    {
        User::factory()->count(5)->create();

        $users = $this->userService->getAllUsers();

        $this->assertCount(5, $users);
        $this->assertInstanceOf(User::class, $users->first());
    }

    public function testGetUserById(): void
    {
        $user = User::factory()->create();

        $fetchedUser = $this->userService->getUserById($user->id);

        $this->assertInstanceOf(User::class, $fetchedUser);
        $this->assertEquals($user->id, $fetchedUser->id);
    }

    public function testUpdateUser(): void
    {
        $user = User::factory()->create();

        $updatedData = [
            'first_name' => 'Jane',
            'last_name'  => 'Smith',
            'password'   => 'newpassword123',
        ];

        $updatedUser = $this->userService->updateUser($user->id, $updatedData);

        $this->assertEquals('Jane', $updatedUser->first_name);
        $this->assertEquals('Smith', $updatedUser->last_name);
        $this->assertTrue(Hash::check('newpassword123', $updatedUser->password));
    }

    public function testSoftDeleteUser(): void
    {
        $user = User::factory()->create();

        $deletedUser = $this->userService->softDeleteUser($user->id);

        $this->assertSoftDeleted($deletedUser);
    }

    public function testHardDeleteUser(): void
    {
        $user = User::factory()->create();

        $this->userService->softDeleteUser($user->id);
        $this->userService->hardDeleteUser($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
