<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_create_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $data = [
            'name' => 'Rick',
            'email' => 'rber@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->postJson(route('user.store'), $data);

        // $personal = $response->getOriginalContent()['data'];

		$response->assertStatus(201);
    }

    /** @test */
    public function cannot_create_user_without_authenticated()
    {
        $data = [
            'name' => 'Rick',
            'email' => 'rber@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->postJson(route('user.store'), $data);

		$response->assertStatus(401);
    }
}
