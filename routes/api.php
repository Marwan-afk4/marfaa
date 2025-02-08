<?php

use App\Http\Controllers\Api\Admin\AreaController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\SubCategoryController;
use App\Http\Controllers\Api\Admin\UserController;
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

    Route::delete('/admin/area/delete/{id}', [AreaController::class, 'deleteArea']);

//////////////////////////////////////// Cities //////////////////////////////////////////////////

    Route::get('/admin/cities', [CityController::class, 'getCities']);

    Route::post('/admin/add/city', [CityController::class, 'addCity']);

    Route::delete('/admin/city/delete/{id}', [CityController::class, 'deleteCity']);

    Route::put('/admin/city/update/{id}', [CityController::class, 'updateCity']);

/////////////////////////////////////// Category //////////////////////////////////////////////////

    Route::get('/admin/categories', [CategoryController::class, 'getCategories']);

    Route::post('/admin/add/category', [CategoryController::class, 'addCategory']);

    Route::delete('/admin/category/delete/{id}', [CategoryController::class, 'deleteCategory']);

    Route::put('/admin/category/update/{id}', [CategoryController::class, 'updateCategory']);

/////////////////////////////////////// SubCategory //////////////////////////////////////////////////

    Route::get('/admin/subCategories', [SubCategoryController::class, 'getSubCategories']);

    Route::post('/admin/add/subCategory', [SubCategoryController::class, 'addSubCategory']);

    Route::delete('/admin/subCategory/delete/{id}', [SubCategoryController::class, 'deleteSubCategory']);

    Route::put('/admin/subCategory/update/{id}', [SubCategoryController::class, 'updateSubCategory']);

/////////////////////////////////////////////// Users //////////////////////////////////////////////////

    Route::get('/admin/users', [UserController::class, 'getUsers']);

    Route::put('/admin/user/update/{id}', [UserController::class, 'updateUser']);

    Route::put('/admin/user/accept/{id}', [UserController::class, 'acceptUser']);

    Route::put('/admin/user/reject/{id}', [UserController::class, 'rejectUser']);

    Route::put('/admin/user/suspend/{id}', [UserController::class, 'suspendUser']);

////////////////////////////////////////////////// Products //////////////////////////////////////////////////

    Route::get('/admin/products', [ProductController::class, 'getProducts']);

});
