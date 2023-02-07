<?php

namespace Tests\Feature\Personal;

use App\Models\Personal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePersonalTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_delete_personal()
    {
        $personal = Personal::factory()->create();

        $response = $this->delete( route('personal.destroy', [$personal->getKey()]) );

        $response->assertStatus(204);

    }
}
