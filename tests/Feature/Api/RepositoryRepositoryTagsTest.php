<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Repository;
use App\Models\RepositoryTag;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryRepositoryTagsTest extends TestCase
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
    public function it_gets_repository_repository_tags(): void
    {
        $repository = Repository::factory()->create();
        $repositoryTag = RepositoryTag::factory()->create();

        $repository->repositoryTags()->attach($repositoryTag);

        $response = $this->getJson(
            route('api.repositories.repository-tags.index', $repository)
        );

        $response->assertOk()->assertSee($repositoryTag->title);
    }

    /**
     * @test
     */
    public function it_can_attach_repository_tags_to_repository(): void
    {
        $repository = Repository::factory()->create();
        $repositoryTag = RepositoryTag::factory()->create();

        $response = $this->postJson(
            route('api.repositories.repository-tags.store', [
                $repository,
                $repositoryTag,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $repository
                ->repositoryTags()
                ->where('repository_tags.id', $repositoryTag->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_repository_tags_from_repository(): void
    {
        $repository = Repository::factory()->create();
        $repositoryTag = RepositoryTag::factory()->create();

        $response = $this->deleteJson(
            route('api.repositories.repository-tags.store', [
                $repository,
                $repositoryTag,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $repository
                ->repositoryTags()
                ->where('repository_tags.id', $repositoryTag->id)
                ->exists()
        );
    }
}
