<?php

use App\Http\Controllers\Api\Admin\AreaController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\HomepageController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\SubCategoryController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Delivery\DeliveryController;
use App\Http\Controllers\Api\Seller\HomepageController as SellerHomepageController;
use App\Http\Controllers\Api\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\UserHomePageController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout']);

Route::get('/seller/getAreas', [SellerHomepageController::class, 'getAreas']);

Route::get('/user/homepage', [UserHomePageController::class, 'HomePage']);


Route::get('/seller/getCities', [SellerHomepageController::class, 'getCities']);

Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {

    Route::delete('/admin/logout', [AuthController::class, 'logout']);

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

    Route::post('/admin/add/product', [ProductController::class, 'addProduct']);

    Route::delete('/admin/product/delete/{id}', [ProductController::class, 'deleteProduct']);

    Route::put('/admin/product/update/{id}', [ProductController::class, 'updateProduct']);

///////////////////////////////////////////////// HOMEpage /////////////////////////////////////////////////////

    Route::get('/admin/homepage', [HomepageController::class, 'HomePage']);

});




Route::middleware(['auth:sanctum','IsSeller'])->group(function () {

    Route::delete('/seller/logout', [AuthController::class, 'logout']);

    Route::get('/seller/homepage', [SellerHomepageController::class, 'HomePage']);

/////////////////////////////////////////////// Products /////////////////////////////////////////////////////////////

    Route::get('/seller/getcategories', [SellerProductController::class, 'getCtegories']);

    Route::get('/seller/getSubCategory', [SellerProductController::class, 'getSubCategory']);

    Route::post('/seller/add/product', [SellerProductController::class, 'addProduct']);

    Route::get('/seller/getSellerProducts', [SellerProductController::class, 'getSellerProducts']);

});



Route::middleware(['auth:sanctum','IsUser'])->group(function () {

    Route::delete('/user/logout', [AuthController::class, 'logout']);


    Route::get('/user/getCtegories', [UserHomePageController::class, 'getCtegories']);

    Route::get('/user/getSubCategory', [UserHomePageController::class, 'getSubCategory']);

    Route::put('/user/addFavourite/{product_id}', [UserHomePageController::class, 'addFavourite']);

    Route::get('/user/getFavourite', [UserHomePageController::class, 'getFavourite']);

    Route::get('/user/getProductrs', [UserHomePageController::class, 'getProductrs']);

/////////////////////////////////////////// Orders /////////////////////////////////////////////////////////////

    Route::get('/user/orders', [OrderController::class, 'previousOrder']);

    Route::post('/user/makeOrder', [OrderController::class, 'makeOrder']);
});





Route::middleware(['auth:sanctum','IsDelivery'])->group(function () {

    Route::delete('/delivery/logout', [AuthController::class, 'logout']);

    Route::get('/delivery/getProcessingOrders', [DeliveryController::class, 'getProcessingOrders']);

    Route::put('/delivery/completedOrder/{order_id}', [DeliveryController::class, 'deliveredOrder']);

    Route::put('/delivery/canceledOrder/{order_id}', [DeliveryController::class, 'canceledOrder']);
});
