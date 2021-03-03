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
        Route::get('pemegang-sertifikasi', 'Api\PemegangSerifikasiController@index')->name('pemegangsertifikasi.index');

        Route::middleware(['auth:api'])
            ->group(function () {
                Route::get('user/me', 'Api\UserController@me')->name('me');

                Route::get('order', 'Api\OrderController@index')->name('order.index');
                Route::post('order', 'Api\OrderController@store')->name('order.store');
                Route::get('order/{id}', 'Api\OrderController@show')->name('order.show');
                Route::post('order/{id}', 'Api\OrderController@update')->name('order.update');

                Route::get('apl01', 'Api\Apl01Controller@index')->name('apl01.index');
                Route::post('apl01', 'Api\Apl01Controller@store')->name('apl01.store');
                Route::post('apl01/customdata', 'Api\Apl01Controller@customdata')->name('apl01.store');

                Route::get('apl02', 'Api\Apl02Controller@index')->name('apl02.index');
                Route::get('apl02/{id}', 'Api\Apl02Controller@show')->name('apl02.show');
                Route::post('apl02', 'Api\Apl02Controller@updateElement')->name('apl02.updateElement');

                Route::get('ujian', 'Api\UjianController@jadwal')->name('ujian.jadwal');
                Route::post('ujian/jawaban', 'Api\UjianController@jawaban')->name('ujian.jawaban');
                Route::post('ujian/jawaban/bulksave', 'Api\UjianController@bulkSave')->name('ujian.bulkSave');
                Route::get('ujian/detail/{id}', 'Api\UjianController@detail')->name('ujian.detail');
                Route::get('ujian/soal/{id}', 'Api\UjianController@soal')->name('ujian.soal');
                Route::post('ujian/{id}/start', 'Api\UjianController@start')->name('ujian.start');
            });
    });
