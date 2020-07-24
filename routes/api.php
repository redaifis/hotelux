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

// Registration & Login
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');
});

// Rooms
Route::group([
    'middleware' => 'api',
    'prefix' => 'rooms'
], function ($router) {
    Route::get('all', 'Api\RoomController@index');
    Route::post('new', 'Api\RoomController@store');
    Route::get('{id}/get', 'Api\RoomController@show');
    Route::put('{id}/update', 'Api\RoomController@update');
    Route::delete('{id}/delete', 'Api\RoomController@destroy');
});

// Articles
Route::group([
    'middleware' => 'api',
    'prefix' => 'articles'
], function ($router) {
    Route::get('all', 'Api\ArticleController@index');
    Route::post('new', 'Api\ArticleController@store');
    Route::get('{id}/get', 'Api\ArticleController@show');
    Route::put('{id}/update', 'Api\ArticleController@update');
    Route::delete('{id}/delete', 'Api\ArticleController@destroy');
});

// hotel information
Route::group([
    'middleware' => 'api',
    'prefix' => 'hotel'
], function ($router) {
    Route::get('get', 'Api\HotelController@index');
    Route::post('new', 'Api\HotelController@store');
});

