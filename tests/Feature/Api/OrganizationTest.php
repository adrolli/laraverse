<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Organization;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationTest extends TestCase
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
    public function it_gets_organizations_list(): void
    {
        $organizations = Organization::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.organizations.index'));

        $response->assertOk()->assertSee($organizations[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_organization(): void
    {
        $data = Organization::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.organizations.store'), $data);

        $this->assertDatabaseHas('organizations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_organization(): void
    {
        $organization = Organization::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
        ];

        $response = $this->putJson(
            route('api.organizations.update', $organization),
            $data
        );

        $data['id'] = $organization->id;

        $this->assertDatabaseHas('organizations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_organization(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->deleteJson(
            route('api.organizations.destroy', $organization)
        );

        $this->assertModelMissing($organization);

        $response->assertNoContent();
    }
}
