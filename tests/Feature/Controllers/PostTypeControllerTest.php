<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PostType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTypeControllerTest extends TestCase
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

    /**
     * @test
     */
    public function it_displays_index_view_with_post_types(): void
    {
        $postTypes = PostType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('post-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.post_types.index')
            ->assertViewHas('postTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_post_type(): void
    {
        $response = $this->get(route('post-types.create'));

        $response->assertOk()->assertViewIs('app.post_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_post_type(): void
    {
        $data = PostType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('post-types.store'), $data);

        $this->assertDatabaseHas('post_types', $data);

        $postType = PostType::latest('id')->first();

        $response->assertRedirect(route('post-types.edit', $postType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_post_type(): void
    {
        $postType = PostType::factory()->create();

        $response = $this->get(route('post-types.show', $postType));

        $response
            ->assertOk()
            ->assertViewIs('app.post_types.show')
            ->assertViewHas('postType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_post_type(): void
    {
        $postType = PostType::factory()->create();

        $response = $this->get(route('post-types.edit', $postType));

        $response
            ->assertOk()
            ->assertViewIs('app.post_types.edit')
            ->assertViewHas('postType');
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

        $response = $this->put(route('post-types.update', $postType), $data);

        $data['id'] = $postType->id;

        $this->assertDatabaseHas('post_types', $data);

        $response->assertRedirect(route('post-types.edit', $postType));
    }

    /**
     * @test
     */
    public function it_deletes_the_post_type(): void
    {
        $postType = PostType::factory()->create();

        $response = $this->delete(route('post-types.destroy', $postType));

        $response->assertRedirect(route('post-types.index'));

        $this->assertModelMissing($postType);
    }
}
