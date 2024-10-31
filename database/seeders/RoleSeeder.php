<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'moderator',
            'manager',
            'member',
            'voter',
            'guest',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
