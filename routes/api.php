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
    Route::get('/sitemap', 'SitemapController@sitemap');
    Route::get('/blog/info','ArticleController@info');
    // 登录
    Route::post('/login','UserController@login')->name('users.login');
    Route::get('/login/{party}/redirect','UserController@redirectToProvider');
    Route::get('/login/{party}/callback','UserController@handleProviderCallback');
    // 注册
    Route::post('/sign','UserController@sign');
    // 发送邮件
    Route::post('/sendEmail','ValidateController@send_email');
    // 忘记密码
    Route::post('/user/forget','ValidateController@forget');
    // 获取友情链接
    Route::get('/link/list','LinkContorller@list')->name('users.link');
    // 获取轮播
    Route::get('/show/list','HomeContorller@list');
    // 获取公告
    Route::get('/sysmess/list','SysMessContorller@list');
    // 获取留言
    Route::get('/message/list','MessageController@list')->name('users.message');
    // 获取评论 (id)
    Route::get('/reply/list','ReplyController@list')->name('users.reply');
    // 获取成长信息
    Route::get('/route/list','RouteController@userList')->name('users.route');
    // // 获取成长信息
    // Route::get('/route/carousel','RouteController@carousel');
    // 获取文章列表
    Route::post('/blog/list','ArticleController@list')->name('users.articlelist');
    // 获取标签列表
    Route::post('/label/list','LabelController@list')->name('users.labellist');
    // 获取类型列表
    Route::get('/class/list','ArticleController@class');
    // 获取类型列表
    Route::get('/blog/search','ArticleController@search');
    // 获取文章内容
    Route::post('/blog/content','ArticleController@content');
    // 点赞文章内容
    Route::post('/blog/click','ArticleController@click');
    // 获取音乐列表
    Route::get('/music/list','MusicController@list');
    // 留言
    Route::post('/message/tourist','MessageController@touristAdd');
    // ->middleware('throttle:10,1');
    //
    Route::post('/admin/pictures/add','ArticleController@pictures');
    //退出登录
    Route::get('/user/logout','UserController@logout')->name('users.logout');
    // 登陆后操作
    Route::middleware('api.refresh')->group(function () {
        // 个人用户信息
        Route::post('/user/info','UserController@userinfo')->name('users.info');
        Route::post('/user/modify','UserController@modify')->name('users.modify');
        Route::post('/message/add','MessageController@add');
        // 评论
        Route::post('user/reply/add','ReplyController@add');
        Route::post('user/message/remove','MessageController@user_remove');
        Route::post('user/reply/remove','ReplyController@user_remove');
        // 获取管理员信息
        Route::get('/user/info','AdminController@info');
        // 修改管理信息
        Route::post('/admin/update','AdminController@update');
    });
    // 管理员登录
    Route::middleware('api.adminlogin')->group(function () {
        Route::post('/admin/login','AdminController@login');
    });
    Route::middleware(['api.refresh','api.admin'])->group(function () {
        // // 获取管理员信息
        // Route::get('/admin/info','AdminController@info');
        // 用户列表可传 0，或1，
        Route::post('/admin/user/list','UserController@list');
        Route::post('/admin/user/remove','UserController@remove');
        // 文章模块
        Route::post('/admin/article/add','ArticleController@add');

        // 文章修改
        Route::post('/admin/article/update','ArticleController@update');
        Route::post('/admin/article/channels','ArticleController@channels');
        Route::post('/admin/article/remove','ArticleController@remove');
        // 获取文章列表
        Route::post('/admin/blog/list','ArticleController@alist');
        // 友情链接模块
        Route::post('admin/link/remove','LinkContorller@remove');
        Route::post('admin/link/list','LinkContorller@index');
        Route::post('admin/link/update','LinkContorller@update');
        Route::post('admin/link/add','LinkContorller@add');

        // 主页轮播模块
        Route::post('admin/show/remove','HomeContorller@remove');
        Route::post('admin/show/list','HomeContorller@index');
        Route::post('admin/show/update','HomeContorller@update');
        Route::post('admin/show/add','HomeContorller@add');
        //公告
        Route::post('admin/sysmess/remove','SysMessContorller@remove');
        Route::post('admin/sysmess/list','SysMessContorller@index');
        Route::post('admin/sysmess/update','SysMessContorller@update');
        Route::post('admin/sysmess/add','SysMessContorller@add');

        // 成长路线模块
        Route::post('admin/route/remove','RouteController@remove');
        Route::post('admin/route/add','RouteController@add');
        Route::get('admin/route/list','RouteController@list');
        Route::post('admin/route/update','RouteController@update');

        // 留言模块
        Route::post('admin/message/remove','MessageController@remove');
        Route::get('admin/message/alist','MessageController@alist');

        // 评论模块
        Route::post('admin/reply/remove','ReplyController@remove');
        Route::get('admin/reply/alist','ReplyController@alist');

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
