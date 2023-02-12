<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_single_user()
    {
        $auth = User::factory()->create();

        Sanctum::actingAs($auth);

        $newUser = User::factory()->create();

        $response = $this->getJson(route('user.show', [$newUser->getKey()]));

        $response->assertExactJson([
            'data' => [
                'id' => (string) $newUser->getKey(),
                'name' => $newUser->name,
                'email' => $newUser->email
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_user()
    {
        $auth = User::factory()->create();

        Sanctum::actingAs($auth);

        $users = User::factory(3)->create();

        $response = $this->getJson(route('user.index'));

        $response->assertJsonCount(4, 'data');

        $response->assertJsonFragment([
            'data' => User::all(['id', 'name', 'email'])
                ->map(function ($item, $key) {
                    return [
                        'id' => (string) $item->id,
                        'name' => $item->name,
                        'email' => $item->email
                    ];
                })
                ->all()
        ]);
    }
}
