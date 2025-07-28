<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\Team;
use Illuminate\Container\Attributes\Context as ContextAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class NewTeamsSeeder extends Seeder
{
    public function run(
        #[ContextAttribute('venues')] array $venues,
        #[ContextAttribute('season')] Season $season,
    ): void {
        for ($i = 0 ; $i <= 4 ; $i++) {
            $team = Team::factory()->create([
                'name' => 'team ' . $i + 1,
                'venue_id' => $i < 3 ? $venues[$i]->id : $venues[2]->id,
                'season_id' => $season->id,
            ]);

            Context::push('teams', $team);
        }

        $bye = Team::factory()->create([
            'name' => 'BYE',
            'venue_id' => $venues[3]->id,
            'season_id' => $season->id,
        ]);

        Context::push('teams', $bye);
    }
}
