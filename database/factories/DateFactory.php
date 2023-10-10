<?php

namespace Database\Factories;

use App\Models\Date;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Date>
 */
class DateFactory extends Factory
{
    protected $model = Date::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'cycle' => $this->faker->date('Y/m'),
            'date' => $this->faker->date(),
            'regular' => $this->faker->boolean(),
            'remark' => $this->faker->words(3, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
