<?php

namespace Database\Factories;

use App\Models\Version;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Version::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'version' => $this->faker->text(255),
            'item_id' => \App\Models\Item::factory(),
        ];
    }
}
