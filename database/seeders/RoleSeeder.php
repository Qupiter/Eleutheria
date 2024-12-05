<?php

namespace Database\Seeders;

use App\Models\Account\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            UserRole::ADMIN->value,
            UserRole::MODERATOR->value,
            UserRole::MANAGER->value,
            UserRole::MEMBER->value,
            UserRole::VOTER->value,
            UserRole::GUEST->value
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
