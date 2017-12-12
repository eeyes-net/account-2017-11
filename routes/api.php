<?php

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

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'Api\UserController@show');
    Route::put('user', 'Api\UserController@update');

    Route::get('user/role/has', 'Api\RoleController@has')->middleware('scope:role.read');
    Route::get('user/permission/can', 'Api\PermissionController@can')->middleware('scope:permission.read');
    Route::get('user/permission/all', 'Api\PermissionController@all')->middleware('scope:permission.read');

    Route::prefix('admin')->namespace('Api\Admin')->middleware([
        'admin',
        'scope:admin.write',
    ])->group(function () {
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


