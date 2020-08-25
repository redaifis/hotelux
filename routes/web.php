<?php

use App\Http\Controllers\MainController;
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

// register & login page
Route::get('/login', 'MainController@login')->name('login');
Route::get('/register', 'MainController@register')->name('register');

Route::get('/', 'MainController@landingPage');

// Customer dashboard
Route::group(['prefix' => 'customer'], function () {
    Route::get('{pages?}/{params?}', function () {
        return view('customer.index');
    });
});

// admin dashboard

Route::group(['prefix' => 'admin'], function () {
    Route::get('{any}', function () {
        return view('admin.admin');
    });
    Route::get('/', function () {
        return view('admin.admin');
    });
});

Route::group(['prefix' => 'rooms'], function () {
    route::get('search/{checkin?}/{checkout?}/{guests?}','MainController@searchRooms');
    route::get('{slug}', 'MainController@showRoom')->name('show-room');
});

Route::group(['prefix' => 'blog'], function () {
    route::get('{id}', 'MainController@blog');
});

Route::view('/thank-you', 'app.ThankYou');
