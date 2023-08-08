<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Models\User;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
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
    public function it_gets_tags_list(): void
    {
        $tags = Tag::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tags.index'));

        $response->assertOk()->assertSee($tags[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_tag(): void
    {
        $data = Tag::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tags.store'), $data);

        $this->assertDatabaseHas('tags', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_tag(): void
    {
        $tag = Tag::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(route('api.tags.update', $tag), $data);

        $data['id'] = $tag->id;

        $this->assertDatabaseHas('tags', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->deleteJson(route('api.tags.destroy', $tag));

        $this->assertModelMissing($tag);

        $response->assertNoContent();
    }
}
