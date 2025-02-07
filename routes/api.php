<?php

use App\Http\Controllers\Api\Admin\AreaController;
use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {

//////////////////////////////////////////// Areas //////////////////////////////////////////////////

    Route::get('/admin/areas', [AreaController::class, 'getAreas']);

    Route::post('/admin/add/area', [AreaController::class, 'addArea']);

    Route::put('/admin/area/update/{id}', [AreaController::class, 'updateArea']);

    Route::delete('/admin/area/{id}', [AreaController::class, 'deleteArea']);

//////////////////////////////////////// Cities //////////////////////////////////////////////////

    Route::get('/admin/cities', [CityController::class, 'getCities']);

    Route::post('/admin/add/city', [CityController::class, 'addCity']);

    Route::delete('/admin/city/{id}', [CityController::class, 'deleteCity']);

    Route::put('/admin/city/update/{id}', [CityController::class, 'updateCity']);


});
