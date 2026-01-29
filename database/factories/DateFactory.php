<?php

namespace Database\Factories;

use App\Models\Date;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Date>
 */
class DateFactory extends Factory
{
    protected $model = Date::class;

    public function definition(): array
    {
        return [
            'date' => \Illuminate\Support\Facades\Date::now()->format('Y-m-d'),
            'regular' => $this->faker->boolean(),
            'title' => $this->faker->words(2, true),
            'remark' => $this->faker->words(3, true),
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),
            'season_id' => Season::factory(),
        ];
    }
}
