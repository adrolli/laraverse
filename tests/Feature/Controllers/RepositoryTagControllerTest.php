<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RepositoryTag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTagControllerTest extends TestCase
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
    public function it_displays_index_view_with_repository_tags(): void
    {
        $repositoryTags = RepositoryTag::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('repository-tags.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.repository_tags.index')
            ->assertViewHas('repositoryTags');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_repository_tag(): void
    {
        $response = $this->get(route('repository-tags.create'));

        $response->assertOk()->assertViewIs('app.repository_tags.create');
    }

    /**
     * @test
     */
    public function it_stores_the_repository_tag(): void
    {
        $data = RepositoryTag::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('repository-tags.store'), $data);

        $this->assertDatabaseHas('repository_tags', $data);

        $repositoryTag = RepositoryTag::latest('id')->first();

        $response->assertRedirect(
            route('repository-tags.edit', $repositoryTag)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_repository_tag(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();

        $response = $this->get(route('repository-tags.show', $repositoryTag));

        $response
            ->assertOk()
            ->assertViewIs('app.repository_tags.show')
            ->assertViewHas('repositoryTag');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_repository_tag(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();

        $response = $this->get(route('repository-tags.edit', $repositoryTag));

        $response
            ->assertOk()
            ->assertViewIs('app.repository_tags.edit')
            ->assertViewHas('repositoryTag');
    }

    /**
     * @test
     */
    public function it_updates_the_repository_tag(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'weight' => $this->faker->randomNumber(0),
        ];

        $response = $this->put(
            route('repository-tags.update', $repositoryTag),
            $data
        );

        $data['id'] = $repositoryTag->id;

        $this->assertDatabaseHas('repository_tags', $data);

        $response->assertRedirect(
            route('repository-tags.edit', $repositoryTag)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_repository_tag(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();

        $response = $this->delete(
            route('repository-tags.destroy', $repositoryTag)
        );

        $response->assertRedirect(route('repository-tags.index'));

        $this->assertModelMissing($repositoryTag);
    }
}
