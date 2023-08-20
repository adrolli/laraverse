<?php

namespace Database\Factories;

use App\Models\Stack;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stack::class;

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
            'build' => [],
            'public' => $this->faker->boolean(),
            'major' => $this->faker->boolean(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
