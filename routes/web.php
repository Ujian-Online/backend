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
        Route::resource('user', 'Admin\UserController');
        Route::resource('assesi', 'Admin\UserAssesiController');
        Route::resource('assesor', 'Admin\UserAssesorController');
        Route::resource('tuk', 'Admin\UserTukController');
    });
