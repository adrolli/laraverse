<?php

namespace Database\Factories;

use App\Models\PostType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostType::class;

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
            'description' => $this->faker->sentence(15),
        ];
    }
}
