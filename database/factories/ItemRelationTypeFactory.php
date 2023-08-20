<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ItemRelationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemRelationTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemRelationType::class;

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
