<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\Visit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
