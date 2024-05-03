<?php

namespace Database\Factories\Chat;

use App\Models\Chat\ChatRoom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChatRoomFactory extends Factory
{
    protected $model = ChatRoom::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'user_id' => User::whereKeyNot(1)->whereNotNull('last_game')->inRandomOrder('id')->first()->pluck('id'),
            'private' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
