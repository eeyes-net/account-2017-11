<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('user', 'Api\UserController@show');
Route::middleware('auth:api')->put('user', 'Api\UserController@update');

Route::middleware('auth:api')->get('user/permission/hasRole', 'Api\RoleController@has')
    ->middleware('scope:role.read');
Route::middleware('auth:api')->get('user/permission/can', 'Api\PermissionController@can')
    ->middleware('scope:permission.read');
Route::middleware('auth:api')->get('user/permission/all', 'Api\PermissionController@all')
    ->middleware('scope:permission.read');
