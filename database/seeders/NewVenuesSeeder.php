<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class NewVenuesSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1 ; $i <= 3 ; $i++) {
            $user = User::factory()->create([
                'name' => "Owner $i",
            ]);
            $venue = Venue::factory()->create([
                'name' => "venue $i",
                'user_id' => $user->id,
                'contact_name' => $user->name,
                'contact_nr' => $user->contact_nr,
            ]);

            Context::push('owners', $user);
            Context::push('venues', $venue);
        }

        $bye = Venue::factory()->create([
            'name' => 'BYE',
            'user_id' => null,
            'address' => null,
            'contact_name' => null,
            'contact_nr' => null,
            'remark' => null,
            'lat' => null,
            'lng' => null,
        ]);

        Context::push('venues', $bye);
    }
}
