<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'captain' => $this->faker->boolean(),
            'contact_nr' => $this->faker->phoneNumber(),
            'cycle' => $this->faker->date('Y/m'),
            'pool_team_id' => Team::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
