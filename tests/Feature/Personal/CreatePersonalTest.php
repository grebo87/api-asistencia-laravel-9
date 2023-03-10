<?php

namespace Tests\Feature\Personal;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePersonalTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_create_personal()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $data = [
            'name' => 'Rick',
            'last_name' => 'Ber',
            'identification_number' => '89563258965',
            'code' => '00001',
            'date_of_birth' => now(),
            'email' => 'rber@gmail.com',
            'charge' => 'Administrativo',
            'status' => 'Activo'
        ];

        $response = $this->post(route('personal.store'), $data);

        $personal = $response->getOriginalContent()['data'];

		$response->assertStatus(201);
    }
}
