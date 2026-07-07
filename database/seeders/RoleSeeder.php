<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleName::cases() as $role) {
            $permissions = array_map(
                fn ($permission) => $permission->value,
                $role->permissions(),
            );

            Role::findOrCreate($role->value)->syncPermissions($permissions);
        }
    }
}
