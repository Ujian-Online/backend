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
            Route::get('ujian/jadwal/search', 'Admin\UjianJadwalController@search')->name('ujian.jadwal.search');

            Route::get('akun-saya', 'Admin\MyProfileController@show')->name('akun-saya.show');
            Route::get('akun-saya/edit', 'Admin\MyProfileController@edit')->name('akun-saya.edit');
            Route::patch('akun-saya', 'Admin\MyProfileController@update')->name('akun-saya.update');
        });

        // Route Can be Access For Admin or TUK
        Route::middleware('can:isAdminTuk')->group(function () {
            Route::get('/order', 'Admin\OrderController@index')->name('order.index');
            Route::get('/order/search', 'Admin\OrderController@search')->name('order.search');
            Route::get('/order/{id}', 'Admin\OrderController@show')->name('order.show');
            Route::get('sertifikasi/tuk', 'Admin\SertifikasiTukController@index')->name('sertifikasi.tuk.index');
            Route::get('sertifikasi/tuk/create', 'Admin\SertifikasiTukController@create')->name('sertifikasi.tuk.create');
            Route::post('sertifikasi/tuk', 'Admin\SertifikasiTukController@store')->name('sertifikasi.tuk.store');
            Route::get('sertifikasi/tuk/{id}', 'Admin\SertifikasiTukController@show')->name('sertifikasi.tuk.show');
            Route::get('sertifikasi/tuk/{id}/edit', 'Admin\SertifikasiTukController@edit')->name('sertifikasi.tuk.edit');
            Route::patch('sertifikasi/tuk/{id}', 'Admin\SertifikasiTukController@update')->name('sertifikasi.tuk.update');
            Route::resource('tuk/bank', 'Admin\TukBankController', ['as' => 'tuk']);
            Route::get('ujian/asesi', 'Admin\UjianAsesiAsesorController@index')->name('ujian.asesi.index');
        });

        // Asesor Access Only
        Route::middleware('can:isAdminAsesor')->group(function () {
            Route::get('sertifikasi/uk/search', 'Admin\SertifikasiUnitKompetensiController@search')->name('sertifikasi.uk.search');
            Route::get('sertifikasi/uk/search/sertifikasi', 'Admin\SertifikasiUnitKompetensiController@searchWithSertifikasi')->name('sertifikasi.uk.search.sertifikasi');
            Route::resource('sertifikasi/uk', 'Admin\SertifikasiUnitKompetensiController', ['as' => 'sertifikasi']);
            Route::get('sertifikasi/ukelement/rawform', 'Admin\SertifikasiUnitKompetensiElementController@rawForm')->name('ukelement.rawform');
            Route::resource('sertifikasi/ukelement', 'Admin\SertifikasiUnitKompetensiElementController', ['as' => 'sertifikasi']);


            Route::get('soal/search', 'Admin\SoalController@search')->name('soal.search');
            Route::resource('soal/daftar', 'Admin\SoalController', ['as' => 'soal']);
            Route::get('soal/paket/search', 'Admin\SoalPaketController@search')->name('soal.paket.search');
            Route::resource('soal/paket', 'Admin\SoalPaketController', ['as' => 'soal']);
        });

        // Asesor Access Only
        Route::middleware('can:isAssesor')->group(function () {
            Route::resource('surat-tugas', 'Asesor\SuratTugasController')->except(['create', 'store', 'destroy']);
            Route::resource('ujian-asesi', 'Asesor\UjianAsesiPenilaianController');
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

            Route::get('tuk/search', 'Admin\TukController@search')->name('tuk.search');
            Route::resource('tuk', 'Admin\TukController');

            Route::delete('sertifikasi/tuk/{id}', 'Admin\SertifikasiTukController@destroy')->name('sertifikasi.tuk.destroy');
            Route::resource('sertifikasi', 'Admin\SertifikasiController')->except(['show','index']);

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
            Route::get('ujian/asesi-waiting', 'Admin\UjianAsesiAsesorController@asesiBelumAdaAsesorIndex')->name('ujian.asesi.waiting.index');
            Route::resource('ujian/asesi', 'Admin\UjianAsesiAsesorController', ['as' => 'ujian'])->except('index');
            Route::resource('ujian/jawaban', 'Admin\UjianAsesiJawabanController', ['as' => 'ujian'])->only(['index', 'show']);

            Route::resource('soal/pilihanganda', 'Admin\SoalPilihanGandaController', ['as' => 'soal']);
            Route::resource('soal/paketitem', 'Admin\SoalPaketitemController', ['as' => 'soal']);
            Route::resource('soal/unitkompetensi', 'Admin\SoalUnitKompetensiController', ['as' => 'soal']);
        });

        Route::get('sertifikasi', 'Admin\SertifikasiController@index')->name('sertifikasi.index')->middleware('can:isAdminTukAsesor');
        Route::get('sertifikasi/{id}', 'Admin\SertifikasiController@show')->name('sertifikasi.show')->middleware('can:isAdminTukAsesor');
    });
