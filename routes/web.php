<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group([
    'middleware' => [
        'auth'
    ]
], function () {
    Route::get('dashboard', 'DefaultController@index')->name('dashboard');
    Route::get('profile', 'DefaultController@profile')->name('profile');
    Route::resource('/customers', 'CustomerController');
    Route::group([
        'prefix' => '/customers',
        'as' => 'customer_profile.'
    ], function () {
        Route::post('/{customer}/save_profile', 'CustomerController@saveProfile')->name('save');
        Route::post('/{customer}/change_profile_password', 'CustomerController@changePassword')->name('change_password');
        Route::post('/{customer}/change_profile_photo', 'CustomerController@changePhoto')->name('change_photo');
        Route::post('/{customer}/update_status', 'CustomerController@updateStatus')->name('update_status');
    });
    Route::resource('/traders', 'TraderController');
    Route::resource('/products', 'ProductController');
});

Route::get('get_profile_photo/{filename}/{width?}/{height?}', 'GuestController@getProfilePhoto')->name('get_profile_photo');
