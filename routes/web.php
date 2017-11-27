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

Route::view('/', 'welcome');

Route::get('login', 'Auth\LoginController@login')->middleware('guest')->name('login');
Route::get('logout', 'Auth\LoginController@logout');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::view('home', 'home')->middleware('cas.auth')->name('home');

Route::prefix('admin')->namespace('Admin\Api')->middleware('cas.auth')->group(function () {
    Route::view('/', 'admin.index')->name('admin');
    Route::view('user', 'admin.user');
    Route::view('role', 'admin.role');
    Route::view('permission', 'admin.permission');
    Route::prefix('api')->group(function () {
        Route::resource('user', 'UserController', [
            'only' => [
                'index',
                'store',
                'show',
                'update',
                // 'destroy',
            ],
        ]);
        Route::resource('role', 'RoleController', [
            'only' => [
                'index',
                'store',
                'show',
                'update',
                // 'destroy',
            ],
        ]);
        Route::resource('permission', 'PermissionController', [
            'only' => [
                'index',
                'store',
                'show',
                'update',
                // 'destroy',
            ],
        ]);
    });
});

if (App::environment('local')) {
    Route::prefix('test')->group(function () {
        Route::get('login', function () {
            Auth::login(\App\User::first());
            return redirect('/');
        });
    });
}
