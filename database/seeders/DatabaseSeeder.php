<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions first, then roles that reference them, then players.
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            PlayerSeeder::class,
        ]);

        $password = config('auth.demo_password');

        // One user per role, derived from the enum so nothing is hardcoded.
        foreach (RoleName::cases() as $role) {
            User::firstOrCreate(
                ['email' => $role->value.'@example.com'],
                ['name' => Str::headline($role->value), 'password' => Hash::make($password)]
            )->syncRoles($role->value);
        }
    }
}
