<?php

namespace Database\Seeders;

use App\Models\Forum\Comment;
use App\Models\Forum\Post;
use App\Models\Forum\Tag;
use App\Models\Forum\Visit;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory()->count(10)->create();
        for ($i = 1; $i <= 20; $i++) {
            $user = User::query()->inRandomOrder()->first();
            Post::factory()
                ->count(3)
                ->for($user)
//                ->for(Tag::query()->inRandomOrder()->first(), 'tags')
                ->has(Tag::factory()->count(2))
//                ->has(Visit::factory()->count(1))
                ->has(Comment::factory()->for(User::query()->inRandomOrder()->first())->count(2))
                ->create();
        }

    }
}
