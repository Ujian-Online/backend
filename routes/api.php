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

Route::name('api.')
    ->group(function () {
        Route::post('login', 'Api\AuthController@login')->name('login');
        Route::post('register', 'Api\AuthController@register')->name('register');

        // reset password route
        Route::post('password/reset', 'Api\PasswordController@reset')->name('reset');
        Route::post('password/change', 'Api\PasswordController@change')->name('change')->middleware('auth:api');

        // verification route
        Route::post('email/verify', 'Api\VerificationController@verify')
        ->name('verification.verify')->middleware('auth:api');
        Route::post('email/resend', 'Api\VerificationController@resend')
        ->name('verification.resend')->middleware('auth:api');

        // List Sertifikasi
        Route::get('sertifikasi', 'Api\SertifikasiController@index')->name('sertifikasi');
        Route::get('sertifikasi/{id}', 'Api\SertifikasiController@show')->name('sertifikasi.show');

        Route::middleware(['auth:api'])
            ->group(function () {
                Route::get('user/me', 'Api\UserController@me')->name('me');

                Route::get('order', 'Api\OrderController@index')->name('order.index');
                Route::post('order', 'Api\OrderController@store')->name('order.store');
                Route::get('order/{id}', 'Api\OrderController@show')->name('order.show');
                Route::post('order/{id}', 'Api\OrderController@update')->name('order.update');
            });
    });
