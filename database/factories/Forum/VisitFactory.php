<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\Visit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Forum\Visit>
 */
class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
