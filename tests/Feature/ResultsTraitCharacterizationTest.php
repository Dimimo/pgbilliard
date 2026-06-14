<?php

use App\Livewire\Score;
use App\Models\Season;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Context;
use Livewire\Livewire;

/**
 * Characterization (golden-master) test for ResultsTrait::getResults().
 *
 * It does NOT assert what the calculation *should* do; it freezes what it
 * *currently* does, so any behavior change during refactoring fails loudly.
 *
 * The baseline is produced by CompleteSeasonSeeder (5 teams + rotating BYE,
 * a round-robin, plus semi/final events). If you intentionally change the
 * calculation, re-capture the baseline and update EXPECTED below.
 */
beforeEach(function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $season = Season::query()->first();
    Context::addHidden([
        'cycle' => $season->cycle,
        'season_id' => $season->id,
    ]);
});

/**
 * Reduce the getResults() output to a stable, comparable shape.
 *
 * Excludes `id` (autoincrement) and `last_play_date` (a now()-relative Carbon
 * date) because both are environment/time dependent and would make the snapshot
 * flaky. Everything else is pure calculation output.
 */
function snapshotResults(array $scores): array
{
    return collect($scores)
        ->map(function (Collection $result): array {
            $last = $result->get('last_result');
            $played = $result->get('played');

            return [
                'team' => $result->get('team')?->name,
                'played' => is_object($played) ? $played->name : $played,
                'won' => $result->get('won'),
                'lost' => $result->get('lost'),
                'for' => $result->get('for'),
                'against' => $result->get('against'),
                'games_played' => $result->get('games_played'),
                'last_game_won' => $result->get('last_game_won'),
                'percentage' => $result->get('percentage'),
                //'rank' => $result->get('rank'),
                'finals' => $result->get('finals'),
                'max_games' => $result->get('max_games'),
                'last_result' => $last instanceof Collection ? $last->all() : $last,
            ];
        })
        ->all();
}

/**
 * The frozen baseline — captured from the current getResults() implementation.
 */
const EXPECTED_BASELINE = [
    [
        'team' => 'team 1',
        'played' => 'team 2',
        'won' => 14,
        'lost' => 0,
        'for' => 121,
        'against' => 89,
        'games_played' => 14,
        'last_game_won' => false,
        'percentage' => 73,
        /*'rank' => 1,*/ 'finals' => 15,
        'max_games' => 15,
        'last_result' => ['score1' => 8, 'score2' => 7],
    ],
    [
        'team' => 'team 2',
        'played' => 'team 1',
        'won' => 8,
        'lost' => 6,
        'for' => 105,
        'against' => 105,
        'games_played' => 15,
        'last_game_won' => false,
        'percentage' => 50,
        /*'rank' => 2,*/ 'finals' => 15,
        'max_games' => 15,
        'last_result' => ['score1' => 7, 'score2' => 8],
    ],
    [
        'team' => 'team 3',
        'played' => 'team 2',
        'won' => 2,
        'lost' => 7,
        'for' => 65,
        'against' => 70,
        'games_played' => 10,
        'last_game_won' => false,
        'percentage' => 21,
        /*'rank' => 3,*/
        'finals' => 10,
        'max_games' => 15,
        'last_result' => ['score1' => 7, 'score2' => 8],
    ],
    [
        'team' => 'team 4',
        'played' => 'team 1',
        'won' => 1,
        'lost' => 8,
        'for' => 62,
        'against' => 73,
        'games_played' => 10,
        'last_game_won' => false,
        'percentage' => 17,
        /*'rank' => 4,*/ 'finals' => 10,
        'max_games' => 15,
        'last_result' => ['score1' => 7, 'score2' => 8],
    ],
    [
        'team' => 'team 5',
        'played' => 'team 2',
        'won' => 0,
        'lost' => 4,
        'for' => 22,
        'against' => 38,
        'games_played' => 5,
        'last_game_won' => false,
        'percentage' => 4,
        /*'rank' => 5,*/ 'finals' => 5,
        'max_games' => 15,
        'last_result' => ['score1' => 7, 'score2' => 8],
    ],
];

it('produces the frozen baseline for a complete season', function (): void {
    $scores = Livewire::withoutLazyLoading()->test(Score::class)->get('scores');

    expect(snapshotResults($scores))->toEqual(EXPECTED_BASELINE);
});

it('orders the standings by descending percentage', function (): void {
    $scores = Livewire::withoutLazyLoading()->test(Score::class)->get('scores');

    $percentages = collect($scores)->map(fn (Collection $r): int => $r->get('percentage'))->all();

    expect($percentages)
        ->toBe([73, 50, 21, 17, 4])
        ->and($percentages)
        ->toEqual(collect($percentages)->sortDesc()->values()->all());
});
