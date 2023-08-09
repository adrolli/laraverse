<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubTag;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubTagTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_github_tags_list(): void
    {
        $githubTags = GithubTag::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.github-tags.index'));

        $response->assertOk()->assertSee($githubTags[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_github_tag(): void
    {
        $data = GithubTag::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.github-tags.store'), $data);

        $this->assertDatabaseHas('github_tags', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_github_tag(): void
    {
        $githubTag = GithubTag::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
        ];

        $response = $this->putJson(
            route('api.github-tags.update', $githubTag),
            $data
        );

        $data['id'] = $githubTag->id;

        $this->assertDatabaseHas('github_tags', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_github_tag(): void
    {
        $githubTag = GithubTag::factory()->create();

        $response = $this->deleteJson(
            route('api.github-tags.destroy', $githubTag)
        );

        $this->assertModelMissing($githubTag);

        $response->assertNoContent();
    }
}
