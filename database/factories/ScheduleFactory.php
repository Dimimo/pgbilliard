<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'position' => $this->faker->numberBetween(1, 15),
            'player' => $this->faker->randomNumber(),
            'home' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'format_id' => 1,
        ];
    }
}
