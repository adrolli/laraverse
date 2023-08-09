<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

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
            'latest_version' => $this->faker->text(255),
            'website' => $this->faker->text(255),
            'rating' => $this->faker->text(255),
            'health' => $this->faker->text(255),
            'github_url' => $this->faker->text(255),
            'github_stars' => $this->faker->randomNumber(0),
            'packagist_url' => $this->faker->text(255),
            'packagist_name' => $this->faker->text(255),
            'packagist_description' => $this->faker->text(255),
            'packagist_downloads' => $this->faker->randomNumber(0),
            'packagist_favers' => $this->faker->randomNumber(0),
            'npm_url' => $this->faker->text(255),
            'github_maintainers' => $this->faker->randomNumber(0),
            'vendor_id' => \App\Models\Vendor::factory(),
            'type_id' => \App\Models\Type::factory(),
            'github_repo_id' => \App\Models\GithubRepo::factory(),
            'npm_package_id' => \App\Models\NpmPackage::factory(),
            'packagist_package_id' => \App\Models\PackagistPackage::factory(),
        ];
    }
}
