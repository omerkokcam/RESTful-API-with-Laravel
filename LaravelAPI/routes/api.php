<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/categories/custom1",'API\CategoryController@custom1');
Route::get("/products/custom1",'API\ProductController@custom1');
Route::get("/products/custom2",'API\ProductController@custom2');
Route::get("/categories/report1",'API\CategoryController@report1');
Route::get("/users/custom",'API\UserController@custom');

Route::apiResources([
    "products"=> "API\ProductController",
    "users" => "API\UserController",
    "categories" => "API\CategoryController",
]);
