<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Forum\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $word = $this->faker->words(3, true);

        return [
            'title' => $word,
            'slug' => Str::slug($word),
            'body' => $this->faker->realText(),
            'user_id' => User::factory(),
            'is_locked' => $this->faker->boolean(),
            'is_sticky' => $this->faker->boolean(),
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),
        ];
    }
}
