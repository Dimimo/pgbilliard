<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Container\Attributes\Context as ContextAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class NewEventsSeeder extends Seeder
{
    public function run(
        #[ContextAttribute('teams')] array $teams,
        #[ContextAttribute('dates')] array $dates,
    ): void {

        // the full Season schedule, each team plays each other once
        // team 6 is the bye, no scores given
        // the ranking after the first round
        // winner order: team 1, team 2, team 3, team 4, team 5
        // team 6 is the BYE
        $schedule = [
            [[1,2], [3,4], [5,6]],
            [[1,3], [4,5], [2,6]],
            [[2,3], [1,5], [4,6]],
            [[2,4], [3,5], [1,6]],
            [[1,4], [2,5], [3,6]],
        ];

        $score = 12;

        foreach ($schedule as $d => $day) {
            foreach ($day as $game) {
                $event = Event::factory()->create([
                    'date_id' => $dates[$d]->id,
                    'venue_id' => $teams[$game[0] - 1]->venue->id,
                    'team1' => $teams[$game[0] - 1]->id,
                    'team2' => $teams[$game[1] - 1]->id,
                    'score1' => $game[1] !== 6 ? $score : null,
                    'score2' => $game[1] !== 6 ? 15 - $score : null,
                    'confirmed' => true,
                    'remark' => null,
                ]);

                Context::push('events', $event);
            }
            // diminish the score, to create some differentiation
            $score--;

            // fist we add the 2 semi-final games, which are teams 1-4 and 2-3
            // this is semi game 1-4
            $event = Event::factory()->create([
                'date_id' => $dates[$d]->id,
                'venue_id' => $teams[0]->venue->id,
                'team1' => $teams[0]->id,
                'team2' => $teams[3]->id,
                'score1' => 8,
                'score2' => 7,
                'confirmed' => true,
                'remark' => null,
            ]);

            Context::push('events', $event);

            // this is semi game 2-3
            $event = Event::factory()->create([
                'date_id' => $dates[$d]->id,
                'venue_id' => $teams[1]->venue->id,
                'team1' => $teams[1]->id,
                'team2' => $teams[2]->id,
                'score1' => 8,
                'score2' => 7,
                'confirmed' => true,
                'remark' => null,
            ]);

            Context::push('events', $event);

            // finally : the FINAL, in which team 1 wins, team 2 runner-up
            $event = Event::factory()->create([
                'date_id' => $dates[$d]->id,
                'venue_id' => $teams[0]->venue->id,
                'team1' => $teams[0]->id,
                'team2' => $teams[1]->id,
                'score1' => 8,
                'score2' => 7,
                'confirmed' => true,
                'remark' => null,
            ]);

            Context::push('events', $event);

            // et voilà, team 1 wins the Season, team 2 is the runner-up, followed by 3, 4 and 5
        }
    }
}
