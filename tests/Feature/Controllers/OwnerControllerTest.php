<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Owner;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnerControllerTest extends TestCase
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

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_owners(): void
    {
        $owners = Owner::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('owners.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.owners.index')
            ->assertViewHas('owners');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_owner(): void
    {
        $response = $this->get(route('owners.create'));

        $response->assertOk()->assertViewIs('app.owners.create');
    }

    /**
     * @test
     */
    public function it_stores_the_owner(): void
    {
        $data = Owner::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('owners.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('owners', $data);

        $owner = Owner::latest('id')->first();

        $response->assertRedirect(route('owners.edit', $owner));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_owner(): void
    {
        $owner = Owner::factory()->create();

        $response = $this->get(route('owners.show', $owner));

        $response
            ->assertOk()
            ->assertViewIs('app.owners.show')
            ->assertViewHas('owner');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_owner(): void
    {
        $owner = Owner::factory()->create();

        $response = $this->get(route('owners.edit', $owner));

        $response
            ->assertOk()
            ->assertViewIs('app.owners.edit')
            ->assertViewHas('owner');
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

        $data['data'] = json_encode($data['data']);

        $response = $this->put(route('owners.update', $owner), $data);

        $data['id'] = $owner->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('owners', $data);

        $response->assertRedirect(route('owners.edit', $owner));
    }

    /**
     * @test
     */
    public function it_deletes_the_owner(): void
    {
        $owner = Owner::factory()->create();

        $response = $this->delete(route('owners.destroy', $owner));

        $response->assertRedirect(route('owners.index'));

        $this->assertModelMissing($owner);
    }
}
