<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendor::class;

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
            'email' => $this->faker->email(),
            'website' => $this->faker->text(255),
            'github' => $this->faker->text(255),
            'packagist' => $this->faker->text(255),
            'npm' => $this->faker->text(255),
            'organization_id' => \App\Models\Organization::factory(),
            'owner_id' => \App\Models\Owner::factory(),
        ];
    }
}
