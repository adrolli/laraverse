<?php

namespace Database\Factories;

use App\Models\GithubRepo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GithubRepoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GithubRepo::class;

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
            'github_organization_id' => \App\Models\GithubOrganization::factory(),
            'github_owner_id' => \App\Models\GithubOwner::factory(),
        ];
    }
}
