<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Player;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Position>
 */
class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        return [
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),
            'rank' => $this->faker->numberBetween(1, 6),
            'home' => $this->faker->boolean(),

            'event_id' => Event::factory(),
            'player_id' => Player::factory(),
        ];
    }
}
