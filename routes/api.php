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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//USERS ROUTE
// Route::middleware('auth:sanctum')->group(['prefix' => 'users'], function () {
//     Route::post('/', 'App\Http\Controllers\UserController@index');
// });

Route::group(['prefix' => 'users', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\UserController@index');
    Route::post('/block/{user?}', 'App\Http\Controllers\UserController@block');
    Route::post('/unblock/{user?}', 'App\Http\Controllers\UserController@unblock');
    Route::post('/delete/{user?}', 'App\Http\Controllers\UserController@delete');
});

Route::group(['prefix' => 'jobs', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\JobController@index');
    Route::post('/create', 'App\Http\Controllers\JobController@store');
    Route::post('/update/{job}', 'App\Http\Controllers\JobController@update');
    Route::post('/delete/{job?}', 'App\Http\Controllers\JobController@destroy');
});

Route::group(['prefix' => 'categories', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\CategoryController@index');
    Route::post('/create', 'App\Http\Controllers\CategoryController@store');
    Route::post('/update/{category}', 'App\Http\Controllers\CategoryController@update');
    Route::post('/delete/{category?}', 'App\Http\Controllers\CategoryController@destroy');
});

Route::group(['prefix' => 'conditions', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\ConditionController@index');
    Route::post('/create', 'App\Http\Controllers\ConditionController@store');
    Route::post('/update/{condition}', 'App\Http\Controllers\ConditionController@update');
    Route::post('/delete/{condition?}', 'App\Http\Controllers\ConditionController@destroy');
});

Route::group(['prefix' => 'makes', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\MakeController@index');
    Route::post('/create', 'App\Http\Controllers\MakeController@store');
    Route::post('/update/{make}', 'App\Http\Controllers\MakeController@update');
    Route::post('/delete/{make?}', 'App\Http\Controllers\MakeController@destroy');
});

Route::group(['prefix' => 'models', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\ModellController@index');
    Route::post('/create', 'App\Http\Controllers\ModellController@store');
    Route::post('/update/{model}', 'App\Http\Controllers\ModellController@update');
    Route::post('/delete/{model?}', 'App\Http\Controllers\ModellController@destroy');
});

Route::group(['prefix' => 'parts', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\PartController@index');
    Route::post('/create', 'App\Http\Controllers\PartController@store');
    Route::post('/update/{part}', 'App\Http\Controllers\PartController@update');
    Route::post('/delete/{part?}', 'App\Http\Controllers\PartController@destroy');
});

Route::group(['prefix' => 'products', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\ProductController@index');
    Route::post('/create', 'App\Http\Controllers\ProductController@store');
    Route::post('/update/{product}', 'App\Http\Controllers\ProductController@update');
    Route::post('/delete/{product?}', 'App\Http\Controllers\ProductController@destroy');
    Route::post('/enable/{product?}', 'App\Http\Controllers\ProductController@enable');
    Route::post('/disable/{product?}', 'App\Http\Controllers\ProductController@disable');
    Route::get('/{product}', 'App\Http\Controllers\ProductController@getProduct');
});

Route::group(['prefix' => 'gallery', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\GalleryController@index');
    Route::post('/upload', 'App\Http\Controllers\GalleryController@store');
    Route::post('/delete/{gallery}', 'App\Http\Controllers\GalleryController@destroy');
});

//Route::middleware('auth:sanctum')->get('/users', 'App\Http\Controllers\UserController@index');


Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::post('register', 'App\Http\Controllers\UserController@register');

Route::middleware('auth:sanctum')->get('/logout', 'App\Http\Controllers\AuthController@logout');
// Route::post('login', function () {
//     return 'hello world';
// });
