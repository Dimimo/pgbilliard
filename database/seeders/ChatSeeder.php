<?php

namespace Database\Seeders;

use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        ChatRoom::factory()->createOne(['name' => 'General Chat Room', 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()]);
        ChatRoom::factory()->count(10)->create();
        ChatMessage::factory()->count(50)->create();
    }
}
