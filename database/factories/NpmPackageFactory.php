<?php

namespace Database\Factories;

use App\Models\NpmPackage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NpmPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NpmPackage::class;

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
            'data' => [],
        ];
    }
}
