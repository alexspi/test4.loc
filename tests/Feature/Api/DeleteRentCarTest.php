<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteRentCarTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_del_car_rent()
    {
        $response = $this->json('POST', '/api/user/delRent',['user_id'=>1]);
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',

                ]
            ]
        );
    }
}
