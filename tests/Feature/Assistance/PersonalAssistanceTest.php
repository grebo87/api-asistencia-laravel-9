<?php

namespace Tests\Feature\Assistance;

use App\Models\Assistance;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PersonalAssistanceTest extends TestCase
{
    use RefreshDatabase;

    public function actingAsTest()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);
    }
    
    /** @test */
    public function can_get_staff_day_assistance_with_nonexistent_id()
    {
        $this->actingAsTest();
        $response = $this->get( route('personal.get-assistance', [100]) );

        $response->assertStatus(404);
    }

    /** @test */
    public function can_get_staff_day_assistance()
    {
        $this->actingAsTest();
        $personal = Personal::factory()->create();

        $assistance = Assistance::factory()->create([
            'date' => now()->toDateString(),
            'start_time' => now()->toDateTimeString(),
            'time_of' => null,
            'personal_id' => $personal->id,
        ]);

        $response = $this->get( route('personal.get-assistance', [$personal->id]) );

        $response->assertStatus(200);

        $response->assertExactJson([
            'data' => [
                'id' => (string) $assistance->id,
                'date' => $assistance->date->toDateString(),
                'start_time' => $assistance->start_time->toDateTimeString(),
                'time_of' => null,
                'personal_id' => $assistance->personal_id,
            ]
        ]);
    }

    /** @test */
    public function can_mark_the_daily_start_time_for_staff_assistance()
    {
        $this->actingAsTest();
        $personal = Personal::factory()->create();

        $response = $this->post( route('personal.mark-start-time', [$personal->id]) );

		$response->assertStatus(201);
    }

    /** @test */
    public function can_mark_daily_departure_time_for_staff_assistance()
    {
        $this->actingAsTest();
        $personal = Personal::factory()->create();

        $assistance = Assistance::factory()->create([
            'date' => now()->toDateString(),
            'start_time' => now()->toDateTimeString(),
            'time_of' => null,
            'personal_id' => $personal->id,
        ]);

        $response = $this->put( route('personal.mark-time-of', [$personal->id]));

		$response->assertStatus(200);

        $assistance = $response->getOriginalContent()['data'];

        $this->assertEquals(now()->toDateTimeString(), $assistance['time_of']);
    }

    
}
