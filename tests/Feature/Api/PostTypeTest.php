<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PostType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTypeTest extends TestCase
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
    public function it_gets_post_types_list(): void
    {
        $postTypes = PostType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.post-types.index'));

        $response->assertOk()->assertSee($postTypes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_post_type(): void
    {
        $data = PostType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.post-types.store'), $data);

        $this->assertDatabaseHas('post_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_post_type(): void
    {
        $postType = PostType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(
            route('api.post-types.update', $postType),
            $data
        );

        $data['id'] = $postType->id;

        $this->assertDatabaseHas('post_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_post_type(): void
    {
        $postType = PostType::factory()->create();

        $response = $this->deleteJson(
            route('api.post-types.destroy', $postType)
        );

        $this->assertModelMissing($postType);

        $response->assertNoContent();
    }
}
