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

    // Check authentication
    Route::get('check', 'JWTAuthController@checkAuth');
});

// Admin
Route::group([
    'middleware' => ['api', 'admin'],
    'prefix' => 'admin'
], function ($router) {
    // Rooms
    Route::apiResource('rooms', 'Api\v1\Admin\RoomController')->except(['update']);
    Route::get('deleted/rooms', 'Api\v1\Admin\RoomController@deletedRooms');
    Route::put('rooms/{id}/update', 'Api\v1\Admin\RoomController@update');
    Route::put('rooms/{id}/restore', 'Api\v1\Admin\RoomController@restore');
    Route::delete('rooms/{id}/delete', 'Api\v1\Admin\RoomController@permanentDestroy');

    // hotel information
    Route::apiResource('hotel', 'Api\v1\Admin\HotelController');


    // Customers
    Route::apiResource('customers', 'Api\v1\Admin\CustomerController');
    Route::get('total/customers', 'Api\v1\Admin\CustomerController@totalCustomers');
    Route::get('deleted/customers', 'Api\v1\Admin\CustomerController@deletedCustomers');
    Route::put('customers/{id}/restore', 'Api\v1\Admin\CustomerController@restore');
    Route::delete('customers/{id}/delete', 'Api\v1\Admin\CustomerController@permanentDestroy');

    // Reviews
    Route::apiResource('reviews', 'Api\v1\Admin\ReviewController');


    // bookings
    Route::apiResource('bookings', 'Api\v1\Admin\BookingController');
    Route::get('total/bookings', 'Api\v1\Admin\BookingController@totalBookings');

    // Get dashboard counts
    Route::get('counts', 'Api\v1\Admin\AdminController@dashboardCounts');
});

// Customer requests
Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {
    Route::put('profile/{id}', 'Api\v1\Customer\CustomerController@updateProfile');
    Route::put('profile/password/{id}', 'Api\v1\Customer\CustomerController@updatePassword');
    Route::apiResource('bookings', 'Api\v1\Customer\BookingController');
});

// Rooms
Route::group([
    'middleware' => 'api',
    'prefix' => 'rooms'
], function ($router) {
    Route::get('search', 'Api\v1\RoomController@search');
    Route::apiResource('/', 'Api\v1\RoomController')->only(['index', 'show']);
    Route::get('/{id}', 'Api\v1\RoomController@show');
});

// Articles
Route::group([
    'middleware' => 'api',
    'prefix' => 'articles'
], function ($router) {
    Route::apiResource('/', 'Api\v1\ArticleController')->only(['index', 'show']);
    Route::get('/{id}', 'Api\v1\ArticleController@show');
});

// Reviews
Route::group([
    'prefix' => 'reviews',
], function () {
    Route::apiResource('/', 'Api\v1\ReviewsController');
    Route::get('{roomId}/room', 'Api\v1\ReviewsController@roomReviews');
});


// checkout
Route::post('checkout', 'Api\v1\CheckoutController@store');
