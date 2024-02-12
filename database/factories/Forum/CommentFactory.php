<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Comment;
use App\Models\Forum\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'body' => fake()->realText(50),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
