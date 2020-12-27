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

Route::namespace('Api')
    ->name('api.')
    ->group(function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('register', 'AuthController@register')->name('register');

        // verification route
        Route::post('email/verify', 'VerificationController@verify')
        ->name('verification.verify')->middleware('auth:api');
        Route::post('email/resend', 'VerificationController@resend')
        ->name('verification.resend')->middleware('auth:api');

        // List Sertifikasi
        Route::get('sertifikasi', 'SertifikasiController@index')->name('sertifikasi');

        Route::middleware(['auth:api', 'verified'])
            ->group(function () {
                Route::get('me', 'UserController@me')->name('me');

            });
    });
