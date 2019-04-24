<?php

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

Route::group(['middleware' => 'api', 'guard' => 'api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'API\AuthController@login');
        Route::post('logout', 'API\AuthController@logout');
        Route::post('refresh', 'API\AuthController@refresh');
        Route::post('me', 'API\AuthController@me');
        // register
        Route::post('register', 'API\AuthController@register');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    });

    // Route::apiResource('photo', 'API\PhotoController');
    // category list
    Route::get('category', 'API\CategoryController@index');
    // product list
    Route::get('product', 'API\ProductController@index');
    // checkout
    Route::post('order', 'API\OrderController@store');
    //Route::post('payment', 'API\PaymentController@store');
    //Route::post('subscription', 'API\SubscriptionController@store');
    //Route::post('subscription/cancel', 'API\SubscriptionController@destroy');
    Route::apiResource('album-order', 'API\AlbumOrderController');
    Route::post('album-order/add-photos/{album_order_id}', 'API\AlbumOrderController@addPhotos');
    Route::get('album/settings', 'API\AlbumOrderController@settings');
    // data
    Route::get('country', 'API\CountryController@index');
    Route::get('city', 'API\CityController@index');
});
