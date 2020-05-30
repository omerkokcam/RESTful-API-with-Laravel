<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix("basics")->group(function (){
    Route::get("/",function (){
        return view("welcome");
    });
    Route::get('/omer', function () {
        return view('welcome');
    });
    Route::get('/merhaba', function () {
        return ["message"=>"Merhaba"];
    });
    Route::get('/merhaba2', function () {
        return response()->json(["message"=>"merhaba2"])
            ->header("ContentType","application/json");
    });

    Route::get('/category/{slug}', function ($slug) {
        return "Category Slug : $slug" ;
    })->name("category.show");

});
Route::get("/products","ProductController@index")->name("product.index");
Route::post("/products","ProductController@create")->name("product.create");
Route::resource("/products","ProductController");
Route::get('/product/{id}/{type?}',"ProductController@show")->name("product.show");
