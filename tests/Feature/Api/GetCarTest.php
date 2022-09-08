<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCarTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_single_car()
    {
        $response = $this->json('GET', '/api/getcar/4');
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'user_renter' => [
                        '*' => [
                            'id',
                            'name'
                        ]
                    ]
                ]
            ]
        );
    }
}
