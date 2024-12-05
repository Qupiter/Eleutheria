<?php

namespace Tests\Mocks;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Mockery;

trait UserMocks
{
    /**
     * Mock a user with a specific role.
     */
    protected function mockUserWithRole(UserRole $role, int $id = 1): User
    {
        $user = Mockery::mock(User::class)->makePartial();

        // Mock hasRole to return true only for the given role
        $user->shouldReceive('hasRole')
            ->andReturnUsing(function ($inputRole) use ($role) {
                return $inputRole === $role->value;
            });

        $user->id = $id;

        return $user;
    }
}
