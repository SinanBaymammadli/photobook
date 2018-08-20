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
        Route::post('register', 'Auth\RegisterController@register');
    });

    Route::apiResource('photo', 'API\PhotoController');

});
