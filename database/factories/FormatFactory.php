<?php

namespace Database\Factories;

use App\Models\Format;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FormatFactory extends Factory
{
    protected $model = Format::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'details' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
