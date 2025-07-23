<?php

namespace Database\Seeders;

use App\Models\Date;
use App\Models\Event;
use App\Models\Season;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $season = Season::factory()->create();
        $venue1 = Venue::factory()->create();
        $venue2 = Venue::factory()->create();
        $team1 = Team::factory()->create(['season_id' => $season->id, 'venue_id' => $venue1->id]);
        $team2 = Team::factory()->create(['season_id' => $season->id, 'venue_id' => $venue2->id]);

        for ($i = 1; $i <= 4; $i++) {
            Event::factory()
                ->for($team1, 'team_1')
                ->for($team2, 'team_2')
                ->for($venue1, 'venue')
                ->set('confirmed', $i%2)
                ->for(Date::factory()->create(['season_id' => $season->id]))
                ->create();
        }
    }
}
