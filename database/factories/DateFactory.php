<?php

namespace Database\Factories;

use App\Models\Date;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DateFactory extends Factory
{
    protected $model = Date::class;

    public function definition(): array
    {
        return [
            'date' => Carbon::now()->format('Y-m-d'),
            'regular' => $this->faker->boolean(),
            'title' => $this->faker->words(2, true),
            'remark' => $this->faker->words(3, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'season_id' => Season::factory(),
        ];
    }
}
