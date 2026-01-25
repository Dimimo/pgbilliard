<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        $player = Player::query()->inRandomOrder()->first();
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'win' => $this->faker->boolean(),

            'event_id' => 1, //$this->faker->numberBetween(1061, 1071),
            'schedule_id' => Schedule::query()->inRandomOrder()->first()->id,
            'player_id' => $player->id,
            'team_id' => $player->team->id,
            'position' => $this->faker->numberBetween(1, 15),
            'home' => $this->faker->boolean(),
        ];
    }
}
