<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RepositoryType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_repository_types(): void
    {
        $repositoryTypes = RepositoryType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('repository-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.repository_types.index')
            ->assertViewHas('repositoryTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_repository_type(): void
    {
        $response = $this->get(route('repository-types.create'));

        $response->assertOk()->assertViewIs('app.repository_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_repository_type(): void
    {
        $data = RepositoryType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('repository-types.store'), $data);

        $this->assertDatabaseHas('repository_types', $data);

        $repositoryType = RepositoryType::latest('id')->first();

        $response->assertRedirect(
            route('repository-types.edit', $repositoryType)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_repository_type(): void
    {
        $repositoryType = RepositoryType::factory()->create();

        $response = $this->get(route('repository-types.show', $repositoryType));

        $response
            ->assertOk()
            ->assertViewIs('app.repository_types.show')
            ->assertViewHas('repositoryType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_repository_type(): void
    {
        $repositoryType = RepositoryType::factory()->create();

        $response = $this->get(route('repository-types.edit', $repositoryType));

        $response
            ->assertOk()
            ->assertViewIs('app.repository_types.edit')
            ->assertViewHas('repositoryType');
    }

    /**
     * @test
     */
    public function it_updates_the_repository_type(): void
    {
        $repositoryType = RepositoryType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
        ];

        $response = $this->put(
            route('repository-types.update', $repositoryType),
            $data
        );

        $data['id'] = $repositoryType->id;

        $this->assertDatabaseHas('repository_types', $data);

        $response->assertRedirect(
            route('repository-types.edit', $repositoryType)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_repository_type(): void
    {
        $repositoryType = RepositoryType::factory()->create();

        $response = $this->delete(
            route('repository-types.destroy', $repositoryType)
        );

        $response->assertRedirect(route('repository-types.index'));

        $this->assertModelMissing($repositoryType);
    }
}
