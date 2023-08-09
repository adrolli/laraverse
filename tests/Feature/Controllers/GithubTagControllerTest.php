<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\GithubTag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubTagControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_github_tags(): void
    {
        $githubTags = GithubTag::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('github-tags.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.github_tags.index')
            ->assertViewHas('githubTags');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_github_tag(): void
    {
        $response = $this->get(route('github-tags.create'));

        $response->assertOk()->assertViewIs('app.github_tags.create');
    }

    /**
     * @test
     */
    public function it_stores_the_github_tag(): void
    {
        $data = GithubTag::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('github-tags.store'), $data);

        $this->assertDatabaseHas('github_tags', $data);

        $githubTag = GithubTag::latest('id')->first();

        $response->assertRedirect(route('github-tags.edit', $githubTag));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_github_tag(): void
    {
        $githubTag = GithubTag::factory()->create();

        $response = $this->get(route('github-tags.show', $githubTag));

        $response
            ->assertOk()
            ->assertViewIs('app.github_tags.show')
            ->assertViewHas('githubTag');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_github_tag(): void
    {
        $githubTag = GithubTag::factory()->create();

        $response = $this->get(route('github-tags.edit', $githubTag));

        $response
            ->assertOk()
            ->assertViewIs('app.github_tags.edit')
            ->assertViewHas('githubTag');
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

        $response = $this->put(route('github-tags.update', $githubTag), $data);

        $data['id'] = $githubTag->id;

        $this->assertDatabaseHas('github_tags', $data);

        $response->assertRedirect(route('github-tags.edit', $githubTag));
    }

    /**
     * @test
     */
    public function it_deletes_the_github_tag(): void
    {
        $githubTag = GithubTag::factory()->create();

        $response = $this->delete(route('github-tags.destroy', $githubTag));

        $response->assertRedirect(route('github-tags.index'));

        $this->assertModelMissing($githubTag);
    }
}
