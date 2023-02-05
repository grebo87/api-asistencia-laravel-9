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

        $url = urldecode(route('personal.index', ['page[size]' => 2, 'page[number]' => 3]));

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data');

        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);

        $response->assertJsonFragment([
            'first' =>  route('personal.index', ['page[size]' => 2, 'page[number]' => 1]),
            'last'  =>  route('personal.index', ['page[size]' => 2, 'page[number]' => 5]),
            'prev'  =>  route('personal.index', ['page[size]' => 2, 'page[number]' => 2]),
            'next'  =>  route('personal.index', ['page[size]' => 2, 'page[number]' => 4])
        ]);
    }
}
