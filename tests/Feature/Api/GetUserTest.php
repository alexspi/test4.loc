<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_single_user()
    {

        $response = $this->json('GET', '/api/getuser/4');
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'car_rent' => [
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
