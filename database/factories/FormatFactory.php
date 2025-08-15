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
        $user = User::factory()->create();

        return [
            'name' => $this->faker->name(),
            'details' => $this->faker->sentence(),
            'user_id' => $user->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
