<?php

namespace App\Services;

use App\Exceptions\Service\UserService\UserAlreadyHasThisRoleException;
use App\Models\Account\User;
use Spatie\Permission\Models\Role;

class UserRoleService
{
    /**
     * Assign a role to a user.
     *
     * @param int $userId
     * @param string $roleName
     * @return User
     * @throws UserAlreadyHasThisRoleException
     */
    public function assign(int $userId, string $roleName): User
    {
        $user = User::findOrFail($userId);

        $role = Role::findByName($roleName, 'web');

        if ($user->hasRole($roleName)) {
            throw new UserAlreadyHasThisRoleException();
        }

        $user->assignRole($roleName);

        return $user;
    }

    /**
     * Remove a role from  user.
     *
     * @param int $userId
     * @param string $roleName
     * @return User
     */
    public function remove(int $userId, string $roleName): User
    {
        $user = User::findOrFail($userId);

        $role = Role::findByName($roleName, 'web');

        $user->removeRole($roleName);

        return $user;
    }
}
