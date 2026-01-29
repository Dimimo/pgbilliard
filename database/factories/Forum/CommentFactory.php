<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Comment;
use App\Models\Forum\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'body' => fake()->realText(50),
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
