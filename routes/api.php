<?php

use App\Http\Controllers\API\RentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('getusers',[RentApiController::class,'getUserAll']);
Route::get('getuser/{id}',[RentApiController::class,'getUser']);
Route::any('user/setRent',[RentApiController::class,'addRentCar']);
Route::post('user/delRent',[RentApiController::class,'delRentCar']);

Route::get('getcars',[RentApiController::class,'getCarAll']);
Route::get('getcar/{id}',[RentApiController::class,'getCar']);