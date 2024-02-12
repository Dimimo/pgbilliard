<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $word = $this->faker->word();

        return [
            'name' => $word,
            'slug' => Str::slug($word),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
