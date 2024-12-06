<?php

namespace Database\Seeders;

use App\Models\Chat\ChatMessage;
use App\Models\Forum\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() === 0) {
            $this->call([UserSeeder::class]);
        }
        /*if (Post::count() === 0) {
            $this->call([PostSeeder::class]);
        }*/
        if (ChatMessage::count() === 0) {
            $this->call([ChatSeeder::class]);
        }
    }
}
