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

// RESET PASSWORD
Route::post('/password/reset', 'ForgotPasswordController@reset');


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

    // EMAIL VERFIFICATION
    Route::get('/email/resend', 'JWTAuthController@resend')->name('verification.resend');
    Route::get('/email/{id}/{hash}', 'JWTAuthController@verify')->name('verification.verify');

    // PASSWORD RESET
    Route::post('password/email', 'JWTAuthController@forgot');

    // Check authentication
    Route::get('check', 'JWTAuthController@checkAuth');
});

// Admin
Route::group([
    'middleware' => ['api', 'admin'],
    'prefix' => 'admin',
    'namespace' => 'Api\v1\Admin',
], function ($router) {
    // Rooms
    Route::apiResource('rooms', 'RoomController')->except(['update']);
    Route::get('deleted/rooms', 'RoomController@deletedRooms');
    Route::put('rooms/{id}/update', 'RoomController@update');
    Route::put('rooms/{id}/restore', 'RoomController@restore');
    Route::delete('rooms/{id}/delete', 'RoomController@permanentDestroy');

    // hotel information
    Route::apiResource('hotel', 'HotelController');


    // Customers
    Route::apiResource('customers', 'CustomerController');
    Route::get('total/customers', 'CustomerController@totalCustomers');
    Route::get('deleted/customers', 'CustomerController@deletedCustomers');
    Route::put('customers/{id}/restore', 'CustomerController@restore');
    Route::delete('customers/{id}/delete', 'CustomerController@permanentDestroy');

    // Reviews
    Route::apiResource('reviews', 'ReviewController');


    // bookings
    Route::apiResource('bookings', 'BookingController');
    Route::get('total/bookings', 'BookingController@totalBookings');

    // Get dashboard counts
    Route::get('counts', 'AdminController@dashboardCounts');

    // Profile
    Route::put('profile/{id}', 'AdminController@updateProfile');
    Route::put('password/{id}', 'AdminController@updatePassword');

});

// Customer requests
Route::group([
    'prefix' => 'customer',
    'middleware' => 'auth:api'
], function () {
    Route::put('profile/{id}', 'Api\v1\Customer\CustomerController@updateProfile');
    Route::put('password/{id}', 'Api\v1\Customer\CustomerController@updatePassword');
    Route::apiResource('bookings', 'Api\v1\Customer\BookingController');

    // reviews
    Route::apiResource('reviews', 'Api\v1\Customer\ReviewController');
});

// Rooms
Route::group([
    'middleware' => 'api',
    'prefix' => 'rooms'
], function ($router) {
    Route::get('recommanded', 'Api\v1\RoomController@recommandedRooms');
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
