<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_delete_user()
    {
        $auth = User::factory()->create();
        Sanctum::actingAs($auth);

        $newUser = User::factory()->create();

        $response = $this->deleteJson(route('user.destroy',[$newUser->getKey()]))->dump();

        $response->assertStatus(200);


        $res = $response->getOriginalContent();

        $this->assertEquals('Usuario eliminado', $res['message']);
        $this->assertEquals(true, $res['status']);
    }

    /** @test */
    public function cannot_delete_same_authenticated_user()
    {
        $auth = User::factory()->create();
        Sanctum::actingAs($auth);

        $response = $this->deleteJson(route('user.destroy',[$auth->getKey()]));

        $response->assertStatus(403);

        $res = $response->getOriginalContent();

        $this->assertEquals(false, $res['status']);
    }
}
