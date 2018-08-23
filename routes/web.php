<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(["prefix" => "admin"], function () {

    Route::group(["middleware" => "guest"], function () {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    });

    Route::group(["middleware" => "admin"], function () {
        // admin auth
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        //
        Route::resource('user', 'UserController');
        Route::get('/home', 'HomeController@index')->name('home');

        // photos
        Route::get('user/{id}/download', 'UserController@downloadAllPhotosAsZip')->name('photo.download');
        Route::get('user/{id}/download/{date}', 'UserController@downloadPhotosByDateAsZip')->name('photo.downloadByDate');
        Route::get('user/{id}/photos/{date}', 'UserController@showPhotosByDate')->name('photo.byDate');
    });

});
