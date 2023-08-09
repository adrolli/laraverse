<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\GithubRepo;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubRepoItemsTest extends TestCase
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
    public function it_gets_github_repo_items(): void
    {
        $githubRepo = GithubRepo::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'github_repo_id' => $githubRepo->id,
            ]);

        $response = $this->getJson(
            route('api.github-repos.items.index', $githubRepo)
        );

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_github_repo_items(): void
    {
        $githubRepo = GithubRepo::factory()->create();
        $data = Item::factory()
            ->make([
                'github_repo_id' => $githubRepo->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.github-repos.items.store', $githubRepo),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($githubRepo->id, $item->github_repo_id);
    }
}
