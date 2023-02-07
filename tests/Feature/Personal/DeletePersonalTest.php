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

        $response->assertStatus(200);


        $personal = $response->getOriginalContent();

        $this->assertEquals('Personal eliminado', $personal['message']);
        $this->assertEquals(true, $personal['status']);

    }

    /** @test */
    public function can_remove_personal_with_nonexistent_id()
    {
        $response = $this->delete( route('personal.destroy', [100]) );

        $response->assertStatus(404);

    }
}
