<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Owner;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnerTest extends TestCase
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
    public function it_gets_owners_list(): void
    {
        $owners = Owner::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.owners.index'));

        $response->assertOk()->assertSee($owners[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_owner(): void
    {
        $data = Owner::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.owners.store'), $data);

        $this->assertDatabaseHas('owners', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_owner(): void
    {
        $owner = Owner::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
        ];

        $response = $this->putJson(route('api.owners.update', $owner), $data);

        $data['id'] = $owner->id;

        $this->assertDatabaseHas('owners', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_owner(): void
    {
        $owner = Owner::factory()->create();

        $response = $this->deleteJson(route('api.owners.destroy', $owner));

        $this->assertModelMissing($owner);

        $response->assertNoContent();
    }
}
