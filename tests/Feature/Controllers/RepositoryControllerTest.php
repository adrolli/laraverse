<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Repository;

use App\Models\Owner;
use App\Models\Organization;
use App\Models\RepositoryType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryControllerTest extends TestCase
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

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_repositories(): void
    {
        $repositories = Repository::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('repositories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.repositories.index')
            ->assertViewHas('repositories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_repository(): void
    {
        $response = $this->get(route('repositories.create'));

        $response->assertOk()->assertViewIs('app.repositories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_repository(): void
    {
        $data = Repository::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);
        $data['composer'] = json_encode($data['composer']);
        $data['npm'] = json_encode($data['npm']);
        $data['code_analyzer'] = json_encode($data['code_analyzer']);

        $response = $this->post(route('repositories.store'), $data);

        $data['data'] = $this->castToJson($data['data']);
        $data['composer'] = $this->castToJson($data['composer']);
        $data['npm'] = $this->castToJson($data['npm']);
        $data['code_analyzer'] = $this->castToJson($data['code_analyzer']);

        $this->assertDatabaseHas('repositories', $data);

        $repository = Repository::latest('id')->first();

        $response->assertRedirect(route('repositories.edit', $repository));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_repository(): void
    {
        $repository = Repository::factory()->create();

        $response = $this->get(route('repositories.show', $repository));

        $response
            ->assertOk()
            ->assertViewIs('app.repositories.show')
            ->assertViewHas('repository');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_repository(): void
    {
        $repository = Repository::factory()->create();

        $response = $this->get(route('repositories.edit', $repository));

        $response
            ->assertOk()
            ->assertViewIs('app.repositories.edit')
            ->assertViewHas('repository');
    }

    /**
     * @test
     */
    public function it_updates_the_repository(): void
    {
        $repository = Repository::factory()->create();

        $organization = Organization::factory()->create();
        $owner = Owner::factory()->create();
        $repositoryType = RepositoryType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'license' => $this->faker->text(255),
            'readme' => $this->faker->text(),
            'data' => [],
            'composer' => [],
            'npm' => [],
            'code_analyzer' => [],
            'package_type' => $this->faker->text(255),
            'organization_id' => $organization->id,
            'owner_id' => $owner->id,
            'repository_type_id' => $repositoryType->id,
        ];

        $data['data'] = json_encode($data['data']);
        $data['composer'] = json_encode($data['composer']);
        $data['npm'] = json_encode($data['npm']);
        $data['code_analyzer'] = json_encode($data['code_analyzer']);

        $response = $this->put(
            route('repositories.update', $repository),
            $data
        );

        $data['id'] = $repository->id;

        $data['data'] = $this->castToJson($data['data']);
        $data['composer'] = $this->castToJson($data['composer']);
        $data['npm'] = $this->castToJson($data['npm']);
        $data['code_analyzer'] = $this->castToJson($data['code_analyzer']);

        $this->assertDatabaseHas('repositories', $data);

        $response->assertRedirect(route('repositories.edit', $repository));
    }

    /**
     * @test
     */
    public function it_deletes_the_repository(): void
    {
        $repository = Repository::factory()->create();

        $response = $this->delete(route('repositories.destroy', $repository));

        $response->assertRedirect(route('repositories.index'));

        $this->assertModelMissing($repository);
    }
}
