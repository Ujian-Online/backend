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
    ->namespace('Admin')
    ->group(function () {
        Route::resource('user', 'UserController');
        Route::resource('assesi', 'UserAssesiController');
    });
