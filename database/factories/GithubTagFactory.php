<?php

namespace Database\Factories;

use App\Models\GithubTag;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GithubTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GithubTag::class;

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
        ];
    }
}
