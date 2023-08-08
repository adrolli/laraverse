<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Version;

use App\Models\Item;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionControllerTest extends TestCase
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
    public function it_displays_index_view_with_versions(): void
    {
        $versions = Version::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('versions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.versions.index')
            ->assertViewHas('versions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_version(): void
    {
        $response = $this->get(route('versions.create'));

        $response->assertOk()->assertViewIs('app.versions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_version(): void
    {
        $data = Version::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('versions.store'), $data);

        $this->assertDatabaseHas('versions', $data);

        $version = Version::latest('id')->first();

        $response->assertRedirect(route('versions.edit', $version));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_version(): void
    {
        $version = Version::factory()->create();

        $response = $this->get(route('versions.show', $version));

        $response
            ->assertOk()
            ->assertViewIs('app.versions.show')
            ->assertViewHas('version');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_version(): void
    {
        $version = Version::factory()->create();

        $response = $this->get(route('versions.edit', $version));

        $response
            ->assertOk()
            ->assertViewIs('app.versions.edit')
            ->assertViewHas('version');
    }

    /**
     * @test
     */
    public function it_updates_the_version(): void
    {
        $version = Version::factory()->create();

        $item = Item::factory()->create();

        $data = [
            'version' => $this->faker->text(255),
            'item_id' => $item->id,
        ];

        $response = $this->put(route('versions.update', $version), $data);

        $data['id'] = $version->id;

        $this->assertDatabaseHas('versions', $data);

        $response->assertRedirect(route('versions.edit', $version));
    }

    /**
     * @test
     */
    public function it_deletes_the_version(): void
    {
        $version = Version::factory()->create();

        $response = $this->delete(route('versions.destroy', $version));

        $response->assertRedirect(route('versions.index'));

        $this->assertModelMissing($version);
    }
}
