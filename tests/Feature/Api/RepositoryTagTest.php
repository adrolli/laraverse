<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RepositoryTag;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTagTest extends TestCase
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
    public function it_gets_repository_tags_list(): void
    {
        $repositoryTags = RepositoryTag::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.repository-tags.index'));

        $response->assertOk()->assertSee($repositoryTags[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_repository_tag(): void
    {
        $data = RepositoryTag::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.repository-tags.store'), $data);

        $this->assertDatabaseHas('repository_tags', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.repository-tags.update', $repositoryTag),
            $data
        );

        $data['id'] = $repositoryTag->id;

        $this->assertDatabaseHas('repository_tags', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_repository_tag(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();

        $response = $this->deleteJson(
            route('api.repository-tags.destroy', $repositoryTag)
        );

        $this->assertModelMissing($repositoryTag);

        $response->assertNoContent();
    }
}
