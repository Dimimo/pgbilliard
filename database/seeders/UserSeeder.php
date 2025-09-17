<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Administrator',
            'email' => 'admin@pgbilliard.com',
            'password' => '$2y$10$lxt/N648rafTnMBuf5gs6O/wsngTxLCCzouKeku0xt8zUgOdyvE2i',
            'contact_nr' => '0919 206 4825',
            'last_game' => now(),
        ]);
        Admin::query()->create([
            'user_id' => 1,
            'assigned_by' => 1,
            'super_admin' => 1,
        ]);
        // User::factory()->count(10)->update();
    }
}
