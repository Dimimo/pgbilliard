<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        $players = Player::query()->get(['id']);

        return [
            'position' => $this->faker->numberBetween(1, 15),
            'player' => $players ? $players->random() : $this->faker->randomNumber(),
            'home' => $this->faker->boolean(),
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),
            'format_id' => 1,
        ];
    }
}
