<?php

namespace Database\Seeders;

use App\Models\Account\User;
use App\Models\Account\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            UserRole::ADMIN->value     => Role::findByName(UserRole::ADMIN->value),
            UserRole::MODERATOR->value => Role::findByName(UserRole::MODERATOR->value),
            UserRole::MANAGER->value   => Role::findByName(UserRole::MANAGER->value),
            UserRole::MEMBER->value    => Role::findByName(UserRole::MEMBER->value),
            UserRole::VOTER->value     => Role::findByName(UserRole::VOTER->value),
            UserRole::GUEST->value     => Role::findByName(UserRole::GUEST->value),
        ];

        $users = [
            [
                'first_name' => 'Alice',
                'last_name'  => 'Admin',
                'email'      => 'alice_admin@example.com',
                'password'   => Hash::make('password123'),
                'phone'      => '1234567890',
                'role'       => UserRole::ADMIN->value,
            ],
            [
                'first_name' => 'Bob',
                'last_name'  => 'Moderator',
                'email'      => 'bob_moderator@example.com',
                'password'   => Hash::make('password123'),
                'phone'      => '1234567891',
                'role'       => UserRole::MODERATOR->value,
            ],
            [
                'first_name' => 'Charlie',
                'last_name'  => 'Manager',
                'email'      => 'charlie_manager@example.com',
                'password'   => Hash::make('password123'),
                'phone'      => '1234567892',
                'role'       => UserRole::MANAGER->value,
            ],
            [
                'first_name' => 'Diana',
                'last_name'  => 'Member',
                'email'      => 'diana_member@example.com',
                'password'   => Hash::make('password123'),
                'phone'      => '1234567893',
                'role'       => UserRole::MEMBER->value,
            ],
            [
                'first_name' => 'Eve',
                'last_name'  => 'Voter',
                'email'      => 'eve_voter@example.com',
                'password'   => Hash::make('password123'),
                'phone'      => '1234567894',
                'role'       => UserRole::VOTER->value,
            ],
            [
                'first_name' => 'George',
                'last_name'  => 'Guest',
                'email'      => 'george_guest@example.com',
                'password'   => Hash::make('password123'),
                'phone'      => '1234567895',
                'role'       => UserRole::GUEST->value,
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'first_name' => $userData['first_name'],
                'last_name'  => $userData['last_name'],
                'email'      => $userData['email'],
                'password'   => $userData['password'],
                'phone'      => $userData['phone'],
            ]);

            // Assign the specific role
            $user->assignRole($roles[$userData['role']]);
        }
    }
}
