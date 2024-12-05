<?php

namespace Tests\Services;

use App\Exceptions\Service\UserService\UserAlreadyHasThisRoleException;
use App\Models\Account\User;
use App\Models\Account\UserRole;
use App\Services\UserRoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRoleServiceTest extends TestCase
{
    use RefreshDatabase;

    private UserRoleService $userRoleService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRoleService = new UserRoleService();
    }

    public function testAssignRoleSuccessfully(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => UserRole::ADMIN->value, 'guard_name' => 'web']);

        $result = $this->userRoleService->assign($user->id, UserRole::ADMIN->value);

        $this->assertTrue($result->hasRole(UserRole::ADMIN->value));
        $this->assertInstanceOf(User::class, $result);
    }

    public function testAssignRoleThrowsExceptionWhenUserAlreadyHasRole(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => UserRole::ADMIN->value, 'guard_name' => 'web']);
        $user->assignRole(UserRole::ADMIN->value);

        $this->expectException(UserAlreadyHasThisRoleException::class);

        $this->userRoleService->assign($user->id, UserRole::ADMIN->value);
    }

    public function testRemoveRoleSuccessfully(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => UserRole::ADMIN->value, 'guard_name' => 'web']);
        $user->assignRole(UserRole::ADMIN->value);

        $result = $this->userRoleService->remove($user->id, UserRole::ADMIN->value);

        $this->assertFalse($result->hasRole(UserRole::ADMIN->value));
        $this->assertInstanceOf(User::class, $result);
    }

    public function testRemoveRoleDoesNotThrowExceptionIfRoleDoesNotExist(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => UserRole::ADMIN->value, 'guard_name' => 'web']);

        $result = $this->userRoleService->remove($user->id, UserRole::ADMIN->value);

        $this->assertFalse($result->hasRole(UserRole::ADMIN->value));
        $this->assertInstanceOf(User::class, $result);
    }
}
