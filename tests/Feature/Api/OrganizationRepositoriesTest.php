<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Repository;
use App\Models\Organization;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationRepositoriesTest extends TestCase
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
    public function it_gets_organization_repositories(): void
    {
        $organization = Organization::factory()->create();
        $repositories = Repository::factory()
            ->count(2)
            ->create([
                'organization_id' => $organization->id,
            ]);

        $response = $this->getJson(
            route('api.organizations.repositories.index', $organization)
        );

        $response->assertOk()->assertSee($repositories[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_organization_repositories(): void
    {
        $organization = Organization::factory()->create();
        $data = Repository::factory()
            ->make([
                'organization_id' => $organization->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.organizations.repositories.store', $organization),
            $data
        );

        $this->assertDatabaseHas('repositories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $repository = Repository::latest('id')->first();

        $this->assertEquals($organization->id, $repository->organization_id);
    }
}
