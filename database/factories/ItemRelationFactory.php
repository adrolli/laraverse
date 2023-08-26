<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ItemRelation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemRelationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemRelation::class;

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
            'data' => [],
            'itemto_id' => $this->faker->randomNumber(),
            'item_relation_type_id' => \App\Models\ItemRelationType::factory(),
            'post_id' => \App\Models\Post::factory(),
            'itemto_id' => \App\Models\Item::factory(),
            'item_id' => \App\Models\Item::factory(),
        ];
    }
}
