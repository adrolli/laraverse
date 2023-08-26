<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Repository;
use App\Models\RepositoryTag;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTagRepositoriesTest extends TestCase
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
    public function it_gets_repository_tag_repositories(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();
        $repository = Repository::factory()->create();

        $repositoryTag->repositories()->attach($repository);

        $response = $this->getJson(
            route('api.repository-tags.repositories.index', $repositoryTag)
        );

        $response->assertOk()->assertSee($repository->title);
    }

    /**
     * @test
     */
    public function it_can_attach_repositories_to_repository_tag(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();
        $repository = Repository::factory()->create();

        $response = $this->postJson(
            route('api.repository-tags.repositories.store', [
                $repositoryTag,
                $repository,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $repositoryTag
                ->repositories()
                ->where('repositories.id', $repository->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_repositories_from_repository_tag(): void
    {
        $repositoryTag = RepositoryTag::factory()->create();
        $repository = Repository::factory()->create();

        $response = $this->deleteJson(
            route('api.repository-tags.repositories.store', [
                $repositoryTag,
                $repository,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $repositoryTag
                ->repositories()
                ->where('repositories.id', $repository->id)
                ->exists()
        );
    }
}
