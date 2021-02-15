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

// Route Admin
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Route Can be Access For Admin, TUK or Asesor
        Route::middleware('can:isAdminTukAsesor')->group(function () {
            Route::get('sertifikasi/search', 'Admin\SertifikasiController@search')->name('sertifikasi.search');
            Route::get('user/search', 'Admin\UserController@search')->name('user.search');
        });

        // Route Can be Access For Admin or TUK
        Route::middleware('can:isAdminTuk')->group(function () {
            Route::get('/order', 'Admin\OrderController@index')->name('order.index');
            Route::get('/order/{id}', 'Admin\OrderController@show')->name('order.show');
        });

        // Asesor Access Only
        Route::middleware('can:isAssesor')->group(function () {
            //
        });

        // TUK Access Only
        Route::middleware('can:isTuk')->group(function () {
            Route::get('/order/{id}/edit', 'Admin\OrderController@edit')->name('order.edit');
            Route::patch('/order/{id}', 'Admin\OrderController@update')->name('order.update');
        });


        // Admin Access Only
        Route::middleware('can:isAdmin')->group(function () {
            Route::resource('user/asesor', 'Admin\UserAsesorController', ['as' => 'user']);
            Route::resource('user/tuk', 'Admin\UserTukController', ['as' => 'user']);
            Route::resource('user', 'Admin\UserController');

            Route::resource('tuk/bank', 'Admin\TukBankController', ['as' => 'tuk']);
            Route::get('tuk/search', 'Admin\TukController@search')->name('tuk.search');
            Route::resource('tuk', 'Admin\TukController');

            Route::resource('sertifikasi/tuk', 'Admin\SertifikasiTukController', ['as' => 'sertifikasi']);
            Route::get('sertifikasi/uk/search', 'Admin\SertifikasiUnitKompetensiController@search')->name('sertifikasi.uk.search');
            Route::resource('sertifikasi/uk', 'Admin\SertifikasiUnitKompetensiController', ['as' => 'sertifikasi']);
            Route::get('sertifikasi/ukelement/rawform', 'Admin\SertifikasiUnitKompetensiElementController@rawForm')->name('ukelement.rawform');
            Route::resource('sertifikasi/ukelement', 'Admin\SertifikasiUnitKompetensiElementController', ['as' => 'sertifikasi']);

            Route::resource('sertifikasi', 'Admin\SertifikasiController');

            Route::resource('asesi/customdata', 'Admin\AsesiCustomDataController', ['as' => 'asesi']);
            Route::resource('asesi/apl01', 'Admin\UserAsesiController', ['as' => 'asesi']);
            Route::resource('asesi/apl01customdata', 'Admin\UserAsesiCustomDataController', ['as' => 'asesi']);

            // APL-02
            Route::get('asesi/apl02/view/{userid}/{sertifikasiid}', 'Admin\AsesiUnitKompetensiDokumenController@apl02View')
                ->name('asesi.apl02.view');
            Route::get('asesi/apl02/edit/{userid}/{sertifikasiid}', 'Admin\AsesiUnitKompetensiDokumenController@apl02ViewEdit')
                ->name('asesi.apl02.viewedit');
            Route::patch('asesi/apl02/update/{userid}/{sertifikasiid}', 'Admin\AsesiUnitKompetensiDokumenController@apl02ViewUpdate')
                ->name('asesi.apl02.viewupdate');
            Route::resource('asesi/apl02', 'Admin\AsesiUnitKompetensiDokumenController', ['as' => 'asesi']);

            Route::resource('asesi/ukelement', 'Admin\AsesiSertifikasiUnitKompetensiElementController', ['as' => 'asesi']);

            Route::resource('ujian/jadwal', 'Admin\UjianJadwalController', ['as' => 'ujian']);
            Route::resource('ujian/asesi', 'Admin\UjianAsesiAsesorController', ['as' => 'ujian']);
            Route::resource('ujian/jawaban', 'Admin\UjianAsesiJawabanController', ['as' => 'ujian']);
            Route::resource('ujian/jawabanpilihan', 'Admin\UjianAsesiJawabanPilihanController', ['as' => 'ujian']);

            Route::get('soal/search', 'Admin\SoalController@search')->name('soal.search');
            Route::resource('soal/daftar', 'Admin\SoalController', ['as' => 'soal']);
            Route::resource('soal/pilihanganda', 'Admin\SoalPilihanGandaController', ['as' => 'soal']);
            Route::get('soal/paket/search', 'Admin\SoalPaketController@search')->name('soal.paket.search');
            Route::resource('soal/paket', 'Admin\SoalPaketController', ['as' => 'soal']);
            Route::resource('soal/paketitem', 'Admin\SoalPaketitemController', ['as' => 'soal']);
            Route::resource('soal/unitkompetensi', 'Admin\SoalUnitKompetensiController', ['as' => 'soal']);
        });
    });
