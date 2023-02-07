<?php

namespace Tests\Feature\Personal;

use App\Models\Personal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginatePersonalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_paginated_personal()
    {
        $personal = Personal::factory(10)->create();

        $url = urldecode(route('personal.index', ['page' => 1, 'per_page' => 3]));

        $response = $this->getJson($url);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);

        $response->assertJsonFragment([
            'first' =>  route('personal.index', ['page' => 1]),
            'last'  =>  route('personal.index', ['page' => 4]),
            'prev'  =>  null,
            'next'  =>  route('personal.index', ['page' => 2])
        ]);
    }
}
