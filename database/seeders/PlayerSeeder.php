<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        $usernames = ['ninja_gaiden', 'shadow_fox', 'pixel_queen'];

        foreach ($usernames as $username) {
            Player::firstOrCreate(['username' => $username]);
        }
    }
}
