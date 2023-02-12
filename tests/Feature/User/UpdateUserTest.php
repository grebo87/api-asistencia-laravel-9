<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Support\Str;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_update_user()
    {
        $auth = User::factory()->create();

        Sanctum::actingAs($auth);

        $newUser = User::factory()->create();

        $dataUpdate = [
            'name' => 'Pedro Perez',
            'email' => 'pperez@email.com'
        ];

        $response = $this->putJson(route('user.update',[$newUser->getKey()]), $dataUpdate);

        $user = $response->getOriginalContent()['data'];

        $this->assertEquals('Pedro Perez', $user['name']);
        $this->assertEquals('pperez@email.com', $user['email']);
    }
}
