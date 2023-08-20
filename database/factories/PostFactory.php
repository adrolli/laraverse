<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->text(),
            'data' => [],
            'item_id' => \App\Models\Item::factory(),
            'user_id' => \App\Models\User::factory(),
            'stack_id' => \App\Models\Stack::factory(),
            'post_type_id' => \App\Models\PostType::factory(),
        ];
    }
}
