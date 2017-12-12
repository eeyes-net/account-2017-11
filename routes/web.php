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

Route::view('/', 'index');

Route::get('login', 'Auth\LoginController@login')->middleware('guest')->name('login');
Route::get('logout', 'Auth\LoginController@logout');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('home', 'home')->name('home');
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::view('/', 'admin.index')->name('admin');
        Route::view('user', 'admin.user');
        Route::view('role', 'admin.role');
        Route::view('permission', 'admin.permission');
    });
});
