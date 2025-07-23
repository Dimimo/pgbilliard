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
            'name' => $this->faker->words(rand(1, 4), true),
            'user_id' => User::factory(),
            'private' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function configure(): ChatRoomFactory
    {
        return $this->afterCreating(function (ChatRoom $room) {
            $user_ids = User::query()->inRandomOrder()->get(['id'])->take(3)->pluck('id')->toArray();
            $room->users()->sync($user_ids, ['created_at' => now(), 'updated_at' => now()]);
            unset($user_ids);
        });
    }
}
