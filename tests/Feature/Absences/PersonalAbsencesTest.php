<?php

namespace Tests\Feature\Absences;

use App\Models\Absence;
use App\Models\Personal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalAbsencesTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_get_staff_day_absences_with_nonexistent_id()
    {
        $response = $this->get( route('personal.get-absences', [100]) );

        $response->assertStatus(404);
    }


    /** @test */
    public function can_record_the_absence_of_staff_without_observations()
    {
        $personal = Personal::factory()->create();
        
        $data =  [
            'date' => now()->toDateString(),
            'type' => 'Inasistencia Injustificada',
            'observation' =>  null,
            'personal_id' => $personal->getKey()
        ];

        $response = $this->post( route('personal.store-absences', [$personal->getKey()]), $data );

		$response->assertStatus(201);

        $absence = $response->getOriginalContent()['data'];

        $this->assertEquals(null, $absence['observation']);
        $this->assertEquals($personal->getKey(), $absence['personal_id']);
    }

    /** @test */
    public function can_record_the_absence_of_staff_with_observation()
    {
        $personal = Personal::factory()->create();
        
        $data =  [
            'date' => now()->toDateString(),
            'type' => 'Reposo Medico',
            'observation' =>  'El personal se encuentra en reposo médico, debido a un accidente',
            'personal_id' => $personal->getKey()
        ];

        $response = $this->post( route('personal.store-absences', [$personal->getKey()]), $data );

		$response->assertStatus(201);

        $absence = $response->getOriginalContent()['data'];

        $this->assertEquals('El personal se encuentra en reposo médico, debido a un accidente', $absence['observation']);
        $this->assertEquals($personal->getKey(), $absence['personal_id']);
    }

    /** @test */
    public function can_update_the_absence_of_staff()
    {
        $personal = Personal::factory()->create();

        $absence = Absence::factory()->create([
            'date' => now()->toDateString(),
            'type' => 'Inasistencia Injustificada',
            'observation' => 'no se porque no vino',
            'personal_id' => $personal->getKey()
        ]);

        $data = [
            'type' => 'Reposo Medico',
            'observation' => 'El personal se encuentra en reposo médico, debido a un accidente',
            'personal_id' => $personal->getKey()
        ];

        $response = $this->put(route('personal.update-absences', [$personal->getKey()]), $data);


        $absence = $response->getOriginalContent()['data'];

        $this->assertEquals('El personal se encuentra en reposo médico, debido a un accidente', $absence['observation']);
        $this->assertEquals('Reposo Medico', $absence['type']);
    }


    /** @test */
    public function can_destroy_the_absence_of_staff()
    {
        $personal = Personal::factory()->create();

        $absence = Absence::factory()->create([
            'date' => now()->toDateString(),
            'type' => 'Inasistencia Injustificada',
            'observation' => 'no se porque no vino',
            'personal_id' => $personal->getKey()
        ]);

        $response = $this->delete( route('personal.destroy-absences', [$personal->getKey()]) );

        $response->assertStatus(200);


        $absence = $response->getOriginalContent();

        $this->assertEquals('Inasistencia eliminada', $absence['message']);
        $this->assertEquals(true, $absence['status']);
    }


    
}
