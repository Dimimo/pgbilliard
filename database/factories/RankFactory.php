<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Rank;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rank>
 */
class RankFactory extends Factory
{
    protected $model = Rank::class;

    public function definition(): array
    {
        return [
            'max_games' => 20,
            'participated' => $this->faker->numberBetween(2, 20),
            'won' => $this->faker->numberBetween(2, 20),
            'lost' => $this->faker->numberBetween(2, 20),
            'played' => $this->faker->numberBetween(2, 20),
            'percentage' => $this->faker->numberBetween(20, 100),
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),

            'season_id' => Season::factory(),
            'player_id' => Player::factory(),
            'user_id' => User::factory(),
        ];
    }
}
