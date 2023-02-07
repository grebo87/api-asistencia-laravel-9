<?php

namespace Tests\Feature\Personal;

use App\Models\Personal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListPersonalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_single_personal()
    {
        $this->withExceptionHandling();

        $personal = Personal::factory()->create();

        $response = $this->getJson(route('personal.show', [$personal->getRouteKey()]));

        $response->assertExactJson([
            'data' => [
                'id' => (string) $personal->getRouteKey(),
                'name' => $personal->name,
                'last_name' => $personal->last_name,
                'identification_number' => $personal->identification_number,
                'code' => $personal->code,
                'date_of_birth' => $personal->date_of_birth->format('Y-m-d'),
                'email' => $personal->email,
                'charge' => $personal->charge,
                'status' => $personal->status
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_personal()
    {
        $personal = Personal::factory(3)->create();

        $response = $this->getJson(route('personal.index'));

        $response->assertJsonCount(3, 'data');

        $response->assertJsonFragment([
            'data' => [
                [
                    'id' => (string) $personal[0]->id,
                    'name' => $personal[0]->name,
                    'last_name' => $personal[0]->last_name,
                    'identification_number' => $personal[0]->identification_number,
                    'code' => $personal[0]->code,
                    'date_of_birth' => $personal[0]->date_of_birth->format('Y-m-d'),
                    'email' => $personal[0]->email,
                    'charge' => $personal[0]->charge,
                    'status' => $personal[0]->status
                ],
                [
                    'id' => (string) $personal[1]->getRouteKey(),
                    'name' => $personal[1]->name,
                    'last_name' => $personal[1]->last_name,
                    'identification_number' => $personal[1]->identification_number,
                    'code' => $personal[1]->code,
                    'date_of_birth' => $personal[1]->date_of_birth->format('Y-m-d'),
                    'email' => $personal[1]->email,
                    'charge' => $personal[1]->charge,
                    'status' => $personal[1]->status
                ],
                [
                    'id' => (string) $personal[2]->getRouteKey(),
                    'name' => $personal[2]->name,
                    'last_name' => $personal[2]->last_name,
                    'identification_number' => $personal[2]->identification_number,
                    'code' => $personal[2]->code,
                    'date_of_birth' => $personal[2]->date_of_birth->format('Y-m-d'),
                    'email' => $personal[2]->email,
                    'charge' => $personal[2]->charge,
                    'status' => $personal[2]->status
                ],
            ]
        ]);
    }
}
