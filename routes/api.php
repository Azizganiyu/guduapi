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
    Route::get('/address', 'App\Http\Controllers\UserController@getAddress');
    Route::post('/address/save', 'App\Http\Controllers\UserController@saveAddress');
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

Route::group(['prefix' => 'orders', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\OrderController@index');
    Route::post('/create', 'App\Http\Controllers\OrderController@store');
    Route::get('/code/{order_code}', 'App\Http\Controllers\OrderController@getOrderByCode');
    Route::post('/delete/{order?}', 'App\Http\Controllers\OrderController@destroy');
    Route::post('/decline/{order?}', 'App\Http\Controllers\OrderController@decline');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'App\Http\Controllers\CategoryController@index');
});

Route::group(['prefix' => 'categories', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', 'App\Http\Controllers\CategoryController@store');
    Route::post('/update/{category}', 'App\Http\Controllers\CategoryController@update');
    Route::post('/delete/{category?}', 'App\Http\Controllers\CategoryController@destroy');
});

Route::group(['prefix' => 'conditions'], function () {
    Route::get('/', 'App\Http\Controllers\ConditionController@index');
});

Route::group(['prefix' => 'conditions', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', 'App\Http\Controllers\ConditionController@store');
    Route::post('/update/{condition}', 'App\Http\Controllers\ConditionController@update');
    Route::post('/delete/{condition?}', 'App\Http\Controllers\ConditionController@destroy');
});

Route::group(['prefix' => 'makes'], function () {
    Route::get('/', 'App\Http\Controllers\MakeController@index');
});

Route::group(['prefix' => 'makes', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', 'App\Http\Controllers\MakeController@store');
    Route::post('/update/{make}', 'App\Http\Controllers\MakeController@update');
    Route::post('/delete/{make?}', 'App\Http\Controllers\MakeController@destroy');
});

Route::group(['prefix' => 'models'], function () {
    Route::get('/', 'App\Http\Controllers\ModellController@index');
});

Route::group(['prefix' => 'models', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', 'App\Http\Controllers\ModellController@store');
    Route::post('/update/{model}', 'App\Http\Controllers\ModellController@update');
    Route::post('/delete/{model?}', 'App\Http\Controllers\ModellController@destroy');
});

Route::group(['prefix' => 'parts'], function () {
    Route::get('/', 'App\Http\Controllers\PartController@index');
});

Route::group(['prefix' => 'parts', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', 'App\Http\Controllers\PartController@store');
    Route::post('/update/{part}', 'App\Http\Controllers\PartController@update');
    Route::post('/delete/{part?}', 'App\Http\Controllers\PartController@destroy');
});

Route::group(['prefix' => 'years'], function () {
    Route::get('/', 'App\Http\Controllers\YearController@index');
    Route::get('/groupedyears/{model}', 'App\Http\Controllers\YearController@getGroupedYears');
});

Route::group(['prefix' => 'years', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', 'App\Http\Controllers\YearController@store');
    Route::post('/update/{year}', 'App\Http\Controllers\YearController@update');
    Route::post('/delete/{year?}', 'App\Http\Controllers\YearController@destroy');
});


Route::group(['prefix' => 'artisan_request', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\ArtisanRequestController@index');
    Route::post('/create', 'App\Http\Controllers\ArtisanRequestController@store');
    Route::post('/delete/{artisan_request?}', 'App\Http\Controllers\ArtisanRequestController@destroy');
    Route::post('/decline/{artisan_request?}', 'App\Http\Controllers\ArtisanRequestController@decline');
});

Route::group(['prefix' => 'cart', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\CartController@index');
    Route::post('/save', 'App\Http\Controllers\CartController@store');
    Route::get('/delete', 'App\Http\Controllers\CartController@destroy');
});


Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'App\Http\Controllers\ProductController@index');
    Route::get('/url/{url}', 'App\Http\Controllers\ProductController@getProductByUrl');
    Route::get('/trending/{category}', 'App\Http\Controllers\ProductController@trending');
    Route::get('/hotdeals', 'App\Http\Controllers\ProductController@hotDeals');
    Route::post('/listings', 'App\Http\Controllers\ProductController@getProductsListings');
    Route::post('/related', 'App\Http\Controllers\ProductController@getRelatedProducts');
    Route::get('/{product}', 'App\Http\Controllers\ProductController@getProduct');
});

Route::group(['prefix' => 'products', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', 'App\Http\Controllers\ProductController@store');
    Route::post('/update/{product}', 'App\Http\Controllers\ProductController@update');
    Route::post('/delete/{product?}', 'App\Http\Controllers\ProductController@destroy');
    Route::post('/enable/{product?}', 'App\Http\Controllers\ProductController@enable');
    Route::post('/disable/{product?}', 'App\Http\Controllers\ProductController@disable');
});

Route::group(['prefix' => 'artisans', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\ArtisanController@index');
    Route::post('/create', 'App\Http\Controllers\ArtisanController@store');
    Route::post('/update/{artisan}', 'App\Http\Controllers\ArtisanController@update');
    Route::post('/delete/{artisan?}', 'App\Http\Controllers\ArtisanController@destroy');
    Route::post('/enable/{artisan?}', 'App\Http\Controllers\ArtisanController@enable');
    Route::post('/disable/{artisan?}', 'App\Http\Controllers\ArtisanController@disable');
    Route::get('/{artisan}', 'App\Http\Controllers\ArtisanController@getArtisan');
});

Route::group(['prefix' => 'gallery', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', 'App\Http\Controllers\GalleryController@index');
    Route::post('/upload', 'App\Http\Controllers\GalleryController@store');
    Route::post('/delete/{gallery}', 'App\Http\Controllers\GalleryController@destroy');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/analytics', 'App\Http\Controllers\Dashboard@getAnalytics');
});

//Route::middleware('auth:sanctum')->get('/users', 'App\Http\Controllers\UserController@index');


Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::post('register', 'App\Http\Controllers\UserController@register');

Route::middleware('auth:sanctum')->get('/logout', 'App\Http\Controllers\AuthController@logout');
// Route::post('login', function () {
//     return 'hello world';
// });
