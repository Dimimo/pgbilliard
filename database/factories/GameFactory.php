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
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'win' => $this->faker->boolean(),

            'event_id' => $this->faker->numberBetween(1061, 1071),
            'schedule_id' => Schedule::inRandomOrder()->first()->id,
            'player_id' => Player::inRandomOrder()->first()->id,
        ];
    }
}
