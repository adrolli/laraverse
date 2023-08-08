<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Platform;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlatformControllerTest extends TestCase
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
    public function it_displays_index_view_with_platforms(): void
    {
        $platforms = Platform::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('platforms.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.platforms.index')
            ->assertViewHas('platforms');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_platform(): void
    {
        $response = $this->get(route('platforms.create'));

        $response->assertOk()->assertViewIs('app.platforms.create');
    }

    /**
     * @test
     */
    public function it_stores_the_platform(): void
    {
        $data = Platform::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('platforms.store'), $data);

        $this->assertDatabaseHas('platforms', $data);

        $platform = Platform::latest('id')->first();

        $response->assertRedirect(route('platforms.edit', $platform));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_platform(): void
    {
        $platform = Platform::factory()->create();

        $response = $this->get(route('platforms.show', $platform));

        $response
            ->assertOk()
            ->assertViewIs('app.platforms.show')
            ->assertViewHas('platform');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_platform(): void
    {
        $platform = Platform::factory()->create();

        $response = $this->get(route('platforms.edit', $platform));

        $response
            ->assertOk()
            ->assertViewIs('app.platforms.edit')
            ->assertViewHas('platform');
    }

    /**
     * @test
     */
    public function it_updates_the_platform(): void
    {
        $platform = Platform::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(route('platforms.update', $platform), $data);

        $data['id'] = $platform->id;

        $this->assertDatabaseHas('platforms', $data);

        $response->assertRedirect(route('platforms.edit', $platform));
    }

    /**
     * @test
     */
    public function it_deletes_the_platform(): void
    {
        $platform = Platform::factory()->create();

        $response = $this->delete(route('platforms.destroy', $platform));

        $response->assertRedirect(route('platforms.index'));

        $this->assertModelMissing($platform);
    }
}
