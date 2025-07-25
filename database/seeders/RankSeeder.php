<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Rank;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        $season = Season::find(1);

        // we create 6 teams with each 4 players
        for ($i = 1; $i <= 6; $i++) {
            $team = Team::factory()->create(['season_id' => $season->id]);
            for ($j = 1; $j <= 4; $j++) {
                $player = Player::factory()->create(['team_id' => $team->id]);
                Rank::factory()->create([
                    'season_id' => $season->id,
                    'player_id' => $player->id,
                    'user_id' => $player->user_id
                ]);
            }
        }
    }
}
