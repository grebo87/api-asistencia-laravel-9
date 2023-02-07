<?php

namespace Tests\Feature\Personal;

use App\Models\Personal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePersonalTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_update_personal()
    {
        $personal = Personal::factory()->create();

        $data = [
            'name' => 'Rick',
            'last_name' => 'Ber',
            'identification_number' => '89563258965',
            'code' => '00001',
            'date_of_birth' => now(),
            'email' => 'rber@gmail.com',
            'charge' => 'Obrero',
            'status' => 'Jubilado'
        ];

        $response = $this->put(route('personal.update', [$personal->getKey()]), $data);


        $personal = $response->getOriginalContent()['data'];

        $this->assertEquals('Obrero', $personal['charge']);
        $this->assertEquals('Jubilado', $personal['status']);
    }

    /** @test */
    public function can_update_personal_with_nonexistent_id()
    {
        $data = [
            'name' => 'Rick',
            'last_name' => 'Ber',
            'identification_number' => '89563258965',
            'code' => '00001',
            'date_of_birth' => now(),
            'email' => 'rber@gmail.com',
            'charge' => 'Obrero',
            'status' => 'Jubilado'
        ];

        $response = $this->put(route('personal.update', [-1]), $data);

        $response->assertStatus(404);

    }
}
