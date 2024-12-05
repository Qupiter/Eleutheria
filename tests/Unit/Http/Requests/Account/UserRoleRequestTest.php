<?php

namespace Tests\Http\Requests\Account;

use App\Http\Requests\Account\UserRoleRequest;
use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Tests\Http\Requests\RequestTest;

class UserRoleRequestTest extends RequestTest
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new UserRoleRequest();
    }

    public function testAuthorizationForAdmin(): void
    {
        $adminUser = $this->mockUserWithRole(UserRole::ADMIN);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($adminUser);

        $this->assertTrue($this->request->authorize());
    }

    public function testAuthorizationFailsForNonAdmin(): void
    {
        $regularUser = $this->mockUserWithRole(UserRole::VOTER);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($regularUser);

        $this->assertFalse($this->request->authorize());
    }

    public function testValidData(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => UserRole::ADMIN->value]);

        $data = [
            'userId'   => $user->id,
            'roleName' => UserRole::ADMIN->value,
        ];

        $this->validateRequest($data, []);
    }

    public function testInvalidUserId(): void
    {
        $role = Role::create(['name' => UserRole::ADMIN->value]);

        $data = [
            'userId'   => 999, // Non-existent user ID
            'roleName' => UserRole::ADMIN->value,
        ];

        $this->validateRequest($data, [
            'userId' => ['The specified user does not exist.'],
        ]);
    }

    public function testInvalidRoleName(): void
    {
        $user = User::factory()->create();

        $data = [
            'userId'   => $user->id,
            'roleName' => 'NonExistentRole',
        ];

        $this->validateRequest($data, [
            'roleName' => ['The specified role does not exist.'],
        ]);
    }

    public function testMissingFields(): void
    {
        $data = [];

        $this->validateRequest($data, [
            'userId'   => ['The user ID is required.'],
            'roleName' => ['The role name is required.'],
        ]);
    }
}
