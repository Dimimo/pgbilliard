<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //        User::factory()->count(10)->create();
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@puertopool.com',
            'password' => Hash::make("_cCS5dv+'g$}Y8K"),
            'contact_nr' => '0919 206 4825',
            'last_game' => now(),
        ]);
        Admin::create([
            'user_id' => 1,
            'assigned_by' => 1,
            'super_admin' => 1,
        ]);
    }
}
