<?php

namespace Database\Factories\Chat;

use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChatMessageFactory extends Factory
{
    protected $model = ChatMessage::class;

    public function definition(): array
    {
        $user_ids = User::query()->whereKeyNot(1)
            ->whereNotNull('last_game')
            ->get()
            ->pluck('id')
            ->toArray();

        $chat_room_ids = ChatRoom::query()->inRandomOrder('id')
            ->get()
            ->pluck('id')
            ->toArray();

        return [
            'message' => $this->faker->words(rand(2, 8), true),
            'user_id' => $this->faker->randomElement($user_ids),
            'chat_room_id' => $this->faker->randomElement($chat_room_ids),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
