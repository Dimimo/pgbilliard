<?php

namespace Database\Seeders;

use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        ChatRoom::factory()->count(10)->create();
        ChatMessage::factory()->count(50)->create();
    }
}
