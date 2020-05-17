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
Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    // 登录
    Route::post('/login','UserController@login')->name('users.login');
    // 注册
    Route::post('/sign','UserController@sign')->name('users.sign');
    // 获取友情链接
    Route::get('/link/list','LinkContorller@list')->name('users.link');
    // 获取留言
    Route::get('/message/list','MessageController@list')->name('users.message');
    // 获取评论 (id)
    Route::get('/reply/list','ReplyController@list')->name('users.reply');
    // 获取成长信息
    Route::get('/route/list','RouteController@userList')->name('users.route');
    // 获取成长信息
    Route::get('/route/carousel','RouteController@carousel');
    // 获取文章列表
    Route::post('/blog/list','ArticleController@list')->name('users.articlelist');
    // 获取标签列表
    Route::post('/label/list','LabelController@list')->name('users.labellist');
    // 获取类型列表
    Route::get('/class/list','ArticleController@class');
    // 获取类型列表
    Route::get('/blog/search','ArticleController@search');
    // 获取文章内容
    Route::post('/blog/content','ArticleController@content')->name('users.articlecontent');
    // 获取音乐列表
    Route::get('/music/list','MusicController@list');
    // 留言
    Route::post('/message/add','MessageController@add');
    // 登陆后操作
    Route::middleware('api.refresh')->group(function () {
        // 个人用户信息
        Route::post('/user/info','UserController@userinfo')->name('users.info');
        Route::post('/user/logout','UserController@logout')->name('users.logout');
        Route::post('/user/modify','UserController@modify')->name('users.modify');
        // 友情链接
        Route::post('user/link/apply','LinkContorller@apply')->name('users.link');
        // 评论
        Route::post('user/reply/add','replyController@add')->name('users.replyadd');
        // 获取管理员信息
        Route::get('/user/info','AdminController@info');
    });

    // 管理员登录
    Route::post('/admin/login','AdminController@login');
    Route::middleware('api.adminlogin')->group(function () {
        // // 获取管理员信息
        // Route::get('/admin/info','AdminController@info');
        // 修改管理信息
        Route::post('/admin/update','AdminController@update');
        // 用户列表可传 0，或1，
        Route::post('/admin/user/list','UserController@list');
        Route::post('/admin/user/remove','UserController@remove');
        // 文章模块
        Route::post('/admin/article/add','ArticleController@add');
        Route::post('/admin/article/remove','ArticleController@remove');
        // 获取文章列表
        Route::post('/admin/blog/list','ArticleController@alist');
        // 友情链接模块
        Route::post('admin/link/remove','LinkContorller@remove');
        Route::post('admin/link/list','LinkContorller@index');
        Route::post('admin/link/update','LinkContorller@update');

        // 成长路线模块
        Route::post('admin/route/remove','RouteController@remove');
        Route::post('admin/route/add','RouteController@add');
        Route::get('admin/route/list','RouteController@list');
        Route::post('admin/route/update','RouteController@update');

        // 留言模块
        Route::post('admin/message/remove','MessageController@remove');
        Route::get('admin/message/alist','MessageController@alist');

        // 评论模块
        Route::post('admin/reply/remove','replyController@remove');
        Route::get('admin/reply/alist','replyController@alist');

        // 标签模块
        Route::post('admin/label/add','LabelController@add');
        Route::post('admin/label/remove','LabelController@remove');

        // 音乐模块
        Route::post('admin/music/add','MusicController@add');
        Route::post('admin/music/remove','MusicController@remove');
        Route::get('admin/music/list','MusicController@alist');
        Route::post('admin/music/update','MusicController@update');
    });

});
