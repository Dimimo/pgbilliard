<?php

namespace Database\Factories;

use App\Models\Date;
use App\Models\Event;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'score1' => $this->faker->numberBetween(0, 12),
            'score2' => $this->faker->numberBetween(0, 12),
            'date_id' => Date::factory(),
            'venue_id' => Venue::factory(),
            'team1' => Team::factory(),
            'team2' => Team::factory(),
            'confirmed' => true,
            'remark' => $this->faker->words(3, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
