<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompleteSeasonSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            NewSeasonSeeder::class,
            NewVenuesSeeder::class,
            NewDatesSeeder::class,
            NewTeamsSeeder::class,
            NewPlayersSeeder::class,
            NewEventsSeeder::class,
        ]);
    }
}
