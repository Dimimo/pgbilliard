<?php

namespace Database\Factories\Chat;

use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChatMessageFactory extends Factory
{
    protected $model = ChatMessage::class;

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'message' => $this->faker->words(random_int(2, User::whereNotNull('last_game')->count())),
            'user_id' => User::whereKeyNot(1)->whereNotNull('last_game')->inRandomOrder('id')->first()->pluck('id'),
            'chat_room_id' => ChatRoom::inRandomOrder('id')->first()->pluck('id'),
        ];
    }
}
