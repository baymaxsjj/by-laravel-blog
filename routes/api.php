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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    // 登录
    Route::post('/login','UserController@login')->name('users.login');
    // 注册
    Route::post('/sign','UserController@sign')->name('users.sign');
    // 登陆后操作
    Route::middleware('api.refresh')->group(function () {
        // 个人用户信息
        Route::post('/user/info','UserController@userinfo')->name('users.info');
        Route::post('/user/logout','UserController@logout')->name('users.logout');
        Route::post('/user/modify','UserController@modify')->name('users.modify');
        Route::post('user/link/apply','LinkContorller@apply')->name('users.link');
    });

    // 管理员登录
    Route::post('/admin/login','AdminController@login')->name('users.adminlogin');
    Route::middleware('api.adminlogin')->group(function () {
        Route::post('/admin/userlist','AdminController@userlist')->name('users.userlist');
        Route::post('admin/link/add','LinkContorller@add')->name('admin.linkadd');
        Route::post('admin/link/remove','LinkContorller@remove')->name('admin.linkremove');
        Route::post('admin/link/index','LinkContorller@index')->name('admin.linkindex');
        Route::post('admin/link/update','LinkContorller@update')->name('admin.linkupdate');
    });

});
