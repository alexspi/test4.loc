<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SetRentCarTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_set_rent_car()
    {
        $response = $this->json('POST', '/api/user/setRent',['user_id'=>11,'car_id'=>6]);
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
