<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticatedUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_the_authenticated_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('user'));

        $response->assertJson([
            'data' => [
                'email' => $user->email
            ]
        ]);
    }

    /** @test */
    public function guests_cannot_fetch_any_user()
    {
        $user = User::factory()->create();


        $this->getJson(route('user'))
            ->assertStatus(401);
    }
}
