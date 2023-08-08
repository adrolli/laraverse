<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Version;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemVersionsTest extends TestCase
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
    public function it_gets_item_versions(): void
    {
        $item = Item::factory()->create();
        $versions = Version::factory()
            ->count(2)
            ->create([
                'item_id' => $item->id,
            ]);

        $response = $this->getJson(route('api.items.versions.index', $item));

        $response->assertOk()->assertSee($versions[0]->version);
    }

    /**
     * @test
     */
    public function it_stores_the_item_versions(): void
    {
        $item = Item::factory()->create();
        $data = Version::factory()
            ->make([
                'item_id' => $item->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.items.versions.store', $item),
            $data
        );

        $this->assertDatabaseHas('versions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $version = Version::latest('id')->first();

        $this->assertEquals($item->id, $version->item_id);
    }
}
