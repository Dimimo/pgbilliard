<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class NewSeasonSeeder extends Seeder
{
    public function run(): void
    {
        $season = Season::factory()->create([
            'cycle' => date('Y/m'),
            'players' => 6,
        ]);

        Context::add('season', $season);
    }
}
