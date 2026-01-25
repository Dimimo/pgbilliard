<?php

namespace Database\Factories;

use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SeasonFactory extends Factory
{
    protected $model = Season::class;

    public function definition(): array
    {
        return [
            'cycle' => $this->faker->dateTimeThisYear()->format('Y/m'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'players' => $this->faker->numberBetween(4, 8),
        ];
    }
}
