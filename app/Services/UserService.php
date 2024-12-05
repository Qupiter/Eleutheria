<?php

namespace App\Services;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new user.
     *
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User
    {
        $user = User::create([
            'first_name' => $userData['first_name'],
            'last_name'  => $userData['last_name'],
            'email'      => $userData['email'],
            'password'   => Hash::make($userData['password']),
            'phone'      => $userData['phone'] ?? null
        ]);

        // default role
        $user->assignRole(UserRole::VOTER->value);

        return $user;
    }

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    /**
     * Get a user by ID.
     *
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $userData
     * @return User
     */
    public function updateUser(int $id, array $userData): User
    {
        $user = User::findOrFail($id);

        if (isset($userData['password'])) {
            $userData['password'] = Hash::make($userData['password']);
        }
        $user->update($userData);

        return $user;
    }

    /**
     * Discards a user
     *
     * @param int $id
     * @return User
     */
    public function softDeleteUser(int $id): User
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $user;
    }

    /**
     * Deletes a user
     *
     * @param int $id
     * @return void
     */
    public function hardDeleteUser(int $id): void
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->forceDelete();
    }
}
