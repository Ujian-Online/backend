<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'can:isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('user/asesi', 'Admin\UserAsesiController', ['as' => 'user']);
        Route::resource('user/asesor', 'Admin\UserAsesorController', ['as' => 'user']);
        Route::resource('user/tuk', 'Admin\UserTukController', ['as' => 'user']);
        Route::resource('user', 'Admin\UserController');

        Route::resource('tuk/bank', 'Admin\TukBankController', ['as' => 'tuk']);
        Route::resource('tuk', 'Admin\TukController');

        Route::resource('sertifikasi/tuk', 'Admin\SertifikasiTukController', ['as' => 'sertifikasi']);
        Route::resource('sertifikasi/uk', 'Admin\SertifikasiUnitKompetensiController', ['as' => 'sertifikasi']);
        Route::resource('sertifikasi/ukelement', 'Admin\SertifikasiUnitKompetensiElementController', ['as' => 'sertifikasi']);
        Route::resource('sertifikasi', 'Admin\SertifikasiController');

        Route::resource('asesi/customdata', 'Admin\UserAsesiCustomDataController', ['as' => 'asesi']);
        Route::resource('asesi/apl01', 'Admin\AsesiCustomDataController', ['as' => 'asesi']);
        Route::resource('asesi/apl02', 'Admin\AsesiUnitKompetensiDokumenController', ['as' => 'asesi']);
        Route::resource('asesi/ukelement', 'Admin\AsesiSertifikasiUnitKompetensiElementController', ['as' => 'asesi']);

        Route::resource('ujian/jadwal', 'Admin\UjianJadwalController', ['as' => 'ujian']);
        Route::resource('ujian/asesi', 'Admin\UjianAsesiAsesorController', ['as' => 'ujian']);
        Route::resource('ujian/jawaban', 'Admin\UjianAsesiJawabanController', ['as' => 'ujian']);
        Route::resource('ujian/jawabanpilihan', 'Admin\UjianAsesiJawabanPilihanController', ['as' => 'ujian']);

        Route::resource('soal/pilihanganda', 'Admin\SoalPilihanGandaController', ['as' => 'soal']);
        Route::resource('soal/paket', 'Admin\SoalPaketController', ['as' => 'soal']);
        Route::resource('soal/paketitem', 'Admin\SoalPaketitemController', ['as' => 'soal']);
    });
