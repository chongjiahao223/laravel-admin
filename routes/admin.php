<?php

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

/*
|--------------------------------------------------------------------------
| 用户登录、退出、更改密码
|--------------------------------------------------------------------------
*/
Route::post('auth/login', 'AuthController@login');
Route::group(['middleware' => 'jwt-auth', 'prefix' => 'auth'], function () {
    Route::post('me', 'AuthController@me');
    Route::post('logout', 'AuthController@logout');
});

/*
|--------------------------------------------------------------------------
| 系统管理模块
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'system', 'middleware' => 'jwt-auth'], function () {
    // 用户管理
    Route::group(['namespace' => 'Admin'], function () {
        Route::post('admins', 'AdminController@index')->middleware('permission:system|admin');
        Route::post('admin/create', 'AdminController@store')->middleware('permission:system|admin_create');
        Route::post('admin/update', 'AdminController@update')->middleware('permission:system|admin_edit');
        Route::post('admin/role', 'AdminController@adminRole')->middleware('permission:system|admin_role');
        Route::post('admin/destroy', 'AdminController@destroy')->middleware('permission:system|admin_delete');
        Route::post('admin/info', 'AdminController@info');
    });

    // 角色管理
    Route::group(['namespace' => 'Role', 'middleware' => 'permission:system'], function () {
        Route::post('role', 'RoleController@index')->middleware('permission:role');
        Route::post('role/create', 'RoleController@store')->middleware('permission:role_create');
        Route::post('role/update', 'RoleController@update')->middleware('permission:role_edit');
        Route::post('role/permission/create', 'RoleController@rolePermission')->middleware('permission:role_permission');
        Route::post('role/destroy', 'RoleController@destroy')->middleware('permission:role_delete');
        Route::get('role/all', 'RoleController@RoleAll');
    });

    // 权限管理
    Route::group(['namespace' => 'Permission', 'middleware' => 'permission:system'], function () {
        Route::get('permission', 'PermissionController@index')->middleware('permission:permission');
        Route::get('permission/tree', 'PermissionController@tree');
        Route::post('permission/create', 'PermissionController@store')->middleware('permission:permission_create');
        Route::post('permission/update', 'PermissionController@update')->middleware('permission:permission_edit');
        Route::post('permission/destroy/{id}', 'PermissionController@destroy')->middleware('permission:permission_delete');
    });
});
