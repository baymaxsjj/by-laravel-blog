<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// 因为我们 Api 控制器的命名空间是 App\Http\Controllers\Api, 而 Laravel 默认只会在命名空间 App\Http\Controllers 下查找控制器，所以需要我们给出 namespace。
// 同时，添加一个 prefix 是为了版本号，方便后期接口升级区分。
Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    Route::get('/users','UserController@index')->name('users.index');
    Route::get('/users/{user}','UserController@show')->name('users.show');
    Route::post('/store','UserController@store')->name('users.store');
    Route::post('/login','UserController@login')->name('users.login');
});
