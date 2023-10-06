<?php

namespace Database\Factories;

use App\Models\Repository;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepositoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Repository::class;

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
            'license' => $this->faker->text(255),
            'readme' => $this->faker->text(),
            'data' => [],
            'composer' => [],
            'npm' => [],
            'code_analyzer' => [],
            'organization_id' => \App\Models\Organization::factory(),
            'owner_id' => \App\Models\Owner::factory(),
            'repository_type_id' => \App\Models\RepositoryType::factory(),
        ];
    }
}
