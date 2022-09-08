<?php
namespace Tests\Controllers\API;


use Illuminate\Http\Response;
use Tests\TestCase;

class RentApiControllerTest extends TestCase
{


    public function testIndexReturnsDataInValidFormat()
    {

        $this->json('get', 'api/getusers')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
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
