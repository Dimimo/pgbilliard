<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@puertopool.com',
            'password' => '$2y$10$3PrkiCismQjySj/MVd36S.h03pUkx6KjK54fscusuveSeQKyuUEp2',
            'contact_nr' => '0919 206 4825',
            'last_game' => now(),
        ]);
        Admin::create([
            'user_id' => 1,
            'assigned_by' => 1,
            'super_admin' => 1,
        ]);
        // User::factory()->count(10)->create();
    }
}
