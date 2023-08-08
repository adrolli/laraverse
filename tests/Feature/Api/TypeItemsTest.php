<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Type;
use App\Models\Item;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeItemsTest extends TestCase
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
    public function it_gets_type_items(): void
    {
        $type = Type::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'type_id' => $type->id,
            ]);

        $response = $this->getJson(route('api.types.items.index', $type));

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_type_items(): void
    {
        $type = Type::factory()->create();
        $data = Item::factory()
            ->make([
                'type_id' => $type->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.types.items.store', $type),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($type->id, $item->type_id);
    }
}
