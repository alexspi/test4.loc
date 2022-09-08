<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAllUsersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_users()
    {
        $response = $this->getJson('/api/getusers');

        $response->assertStatus(200);
        $response->assertJsonStructure(
        [
            'data' => [
                '*' => [
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
        ]
    );
    }
}
