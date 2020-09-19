<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */

/*
 * Route::middleware('auth:api')->get('/user', function (Request $request) {
 * return $request->user();
 * });
 */

Route::prefix('/v1')->namespace('API')->group(function () {
    Route::get('/', [
        'uses' => 'DefaultController@index'
    ]);

    Route::post('login', [
        'uses' => 'DefaultController@login'
    ]);

    Route::post('register', [
        'uses' => 'DefaultController@register'
    ]);

    Route::post('register_as_trader', [
        'uses' => 'DefaultController@registerAsTrader'
    ]);

    Route::get('products', [
        'uses' => 'ProductController@index'
    ]);

    Route::get('products_by_category/{slug}', [
        'uses' => 'ProductController@byCategory'
    ]);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [
            'uses' => 'DefaultController@profile'
        ]);

        Route::prefix('/trader')->namespace('Trader')
            ->group(function () {

            Route::prefix('/products')->group(function () {

                Route::get('/', [
                    'uses' => 'ProductController@index'
                ]);

                Route::post('/store', [
                    'uses' => 'ProductController@store'
                ]);

                Route::patch('/update', [
                    'uses' => 'ProductController@update'
                ]);

                Route::delete('/delete', [
                    'uses' => 'ProductController@delete'
                ]);
            });

            Route::prefix('/orders')->group(function () {

                Route::get('/', [
                    'uses' => 'OrderController@index'
                ]);

                Route::delete('/delete', [
                    'uses' => 'OrderController@delete'
                ]);
            });
        });
    });
});
