<?php

namespace Database\Seeders;

use App\Models\Date;
use App\Models\Season;
use Illuminate\Container\Attributes\Context as ContextAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class NewDatesSeeder extends Seeder
{
    public function run(
        #[ContextAttribute('season')] Season $season
    ): void {
        $start = now()->subMonths(2)->day(3);
        for ($i = 1; $i <= 5; $i++) {
            $date = Date::factory()->create([
                'season_id' => $season->id,
                'date' => $start->format('Y-m-d'),
                'regular' => true,
            ]);

            Context::push('dates', $date);
            $start = $start->addWeek();
        }

        $date = Date::factory()->create([
            'season_id' => $season->id,
            'date' => $start->format('Y-m-d'),
            'regular' => false,
            'title' => 'Semi',
        ]);

        Context::push('dates', $date);

        $date = Date::factory()->create([
            'season_id' => $season->id,
            'date' => $start->addWeek()->format('Y-m-d'),
            'regular' => false,
            'title' => 'Final',
        ]);

        Context::push('dates', $date);
    }
}
