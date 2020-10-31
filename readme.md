### Laravel个人博客后端

### 项目演示

网站首页：[https://www.yunmobai.cn/](https://www.yunmobai.cn/)

网站前端源码：[https://gitee.com/baymaxsjj/by-vue-blog](https://gitee.com/baymaxsjj/by-vue-blog)

网站后端源码：[https://gitee.com/baymaxsjj/by-laravel-blog](https://gitee.com/baymaxsjj/by-laravel-blog)

此项目使用的第三方图床，并配置多个图床，可自定义选择，也可使用又拍云(自行添加)等

<table>
  <tbody>
   <tr>
      <td align="center" valign="middle">
          <img src="https://img-blog.csdnimg.cn/2020103109302977.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3dlaXhpbl80NTI5NDYwNw==,size_16,color_FFFFFF,t_70#pic_center" >
      </td>
      <td align="center" valign="middle">
          <img src="https://img-blog.csdnimg.cn/20201031093613940.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3dlaXhpbl80NTI5NDYwNw==,size_16,color_FFFFFF,t_70#pic_center" >
      </td>
        <td align="center" valign="middle">
          <img src="https://img-blog.csdnimg.cn/20201031093203324.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3dlaXhpbl80NTI5NDYwNw==,size_16,color_FFFFFF,t_70#pic_center" >
      </td>
    </tr>
    <tr>
      <td align="center" valign="middle">
          <img src="https://img-blog.csdnimg.cn/20201031092813332.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3dlaXhpbl80NTI5NDYwNw==,size_16,color_FFFFFF,t_70#pic_center" >
      </td>
      <td align="center" valign="middle">
          <img src="https://img-blog.csdnimg.cn/20201031092919842.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3dlaXhpbl80NTI5NDYwNw==,size_16,color_FFFFFF,t_70#pic_center" >
      </td>
        <td align="center" valign="middle">
          <img src="https://img-blog.csdnimg.cn/2020103109332370.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3dlaXhpbl80NTI5NDYwNw==,size_16,color_FFFFFF,t_70#pic_center" >
      </td>
    </tr>
  </tbody>
</table>

### 项目介绍
Vue版本：2.6.12，Laravel版本：7.0
完成模块：
登录，注册，找回密码（邮箱），第三方登录（QQ,GITEE,GITHUB）
文章管理，用户管理，留言管理，友链管理，公告管理，首页轮播管理，音乐管理，成长路线管理
### 项目配置

```bash
# 安装依赖
composer install 
# 生成key
php artisan key:generate
# 生成jwt-key
php artisan jwt:secret
# 生成数据库表（由于后来修改表结构比较大，就没有去修改数据库迁移，可以直接将database/blog.sql导入数据库即可）
php artisan migrate
# 填充数据
php artisan db:seed
# 启动服务
php artisan serve
# .env 上线配置，注意上线要修改，不然所有报错将会在用户端显示，低版本Laravel 还可能会泄漏.evn配置文件中重要信息
APP_ENV=local 改成 APP_ENV=production
APP_DEBUG=true 改成 APP_DEBUG=false
```
### 第三方登录
此项目目前支持QQ,Gitee,GitHub登录，可以扩展，[第三方登录包](https://socialiteproviders.com/)，下载安装如下配置！Gitee和GitHub直接到个人账号设置里开启就可以直接使用，如要申请QQ 登录，需要到[QQ互联](https://connect.qq.com/manage.html#/)注册开发者，注意多次申请失败（身份证审核失败情况）直接找在线客服，快速审核通过，我就是搞了5，6次没搞好，直接找到客服，十来分钟就审核通过了！

```bash
# 下载对应包，socialiteproviders/第三方登录名
composer require socialiteproviders/qq

# 添加事件监听器 App/Providers/EventServiceProvider
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        # 注意：官方有错误是QqExtendSocialite，不是QQ，这里我按官方给的搞半天没搞好，结果参看原文件，才发现是Qq
        'SocialiteProviders\\QQ\\QqExtendSocialite@handle',
    ],
];

# configure config/services.php
'qq' => [
    'client_id' => env('QQ_CLIENT_ID'),
    'client_secret' => env('QQ_CLIENT_SECRET'),
    'redirect' => env('QQ_REDIRECT_URI'),
]
# .env 中配置
QQ_CLIENT_ID=App ID
QQ_CLIENT_SECRET=App Key
QQ_REDIRECT_URI=回调地址
……
#其它包类似，把QQ改成对应名
# start building 
return Socialite::driver('qq')->redirect();
```
### 扩展第三方登录
由于此项目是动态路由，所以只需按照上方添加第三方登录包后，就可以直接使用。使用的动态路由根据第三方登录名为参数

```php
//第三方登录请求地址
//party 动态参数，是第三方登录名。如：https://域名/login/qq/redirece 
Route::get('/login/{party}/redirect','UserController@redirectToProvider');
//第三方登录回调地址
Route::get('/login/{party}/callback','UserController@handleProviderCallback');
//以下是控制器配置
 /**
	* 将用户重定向到party认证页面
	*
	* @return Response
	*/
	public function redirectToProvider($party)
	{
		// dd($party);
		return Socialite::driver($party)->redirect();
	}
	/**
	* 从party获取用户信息.
	*回调地址
	* @return Response
	*/
	public function handleProviderCallback($party)
	{
		$partyUser= Socialite::driver($party)->stateless()->user();
	}
```

### 安装jwt
使用 JWT 对用户身份验证,
```bash
composer require tymon/jwt-auth
# 修改 config/app.php
'providers' => [
    ...
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]
# 发布配置文件
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
# 生成key
php artisan jwt:secret
```
### 安装邮箱模板

```bash
#安装邮件模版
composer require qoraiche/laravel-mail-editor
# 发布配置文件
php artisan vendor:publish --provider="qoraiche\mailEclipse\mailEclipseServiceProvider"
php artisan migrate
# 访问地址
http://localhost:8080/maileclipse
# 修改模板  /resources/views
编写邮箱模板，可以使用markdown语法也可使用html
# 修改内置模板样式 /resources/viewsvendor
在该文件夹下修改对于的模块样式及布局
# .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.qq.com
MAIL_PORT=465
MAIL_USERNAME=邮箱号
MAIL_PASSWORD=邮箱码
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=邮箱号
MAIL_FROM_NAME=发送者名
```
### 浏览统计

```bash
composer require awssat/laravel-visits
# 添加配置文件
php artisan vendor:publish --provider="awssat\Visits\VisitsServiceProvider"
# 修改.env文件
CACHE_DRIVER=file 改成 CACHE_DRIVER=array
# 需要安装redis，可以在宝塔面板中安装启动，修改密码
#php 需要安装redis 扩展，可在宝塔面板，php 扩展中安装
#.env 配置 
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=密码
REDIS_PORT=6379
```

### 常用命令
```bash
# 添加模型 -m 生成数据库迁移
php artisan make:model Models/Article -m
# 添加控制器
php artisan make:controller Api/ArticleController
# 添加验证
php artisan make:request ArticleRequest
# 清除配置信息缓存
php artisan config:cache
php artisan config:clear
# 路由缓存
php artisan route:cache
php artisan route:clear
# 数据填充
# 生成User模型的工厂
php artisan make:factory UserFactory --model=Models/User
# 生成User的数据填充
php artisan make:seeder UsersTableSeeder
# 数据填充
php artisan db:seed
# 填充指定模型
php artisan db:seed --class=UsersTableSeeder
# 重新生成数据库表并填充数据
php artisan migrate:refresh --seed
# 进入数据填充测试
php artisan tinker
```
### .evn 模板

```bash
APP_NAME= 云墨白
APP_ENV=# local/production
APP_KEY=#  key
APP_DEBUG=# true/false
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=# 数据库名
DB_USERNAME=# 数据库密码
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.qq.com
MAIL_PORT=465
MAIL_USERNAME=# 邮箱名
MAIL_PASSWORD=# 邮箱密码，qq邮箱需到邮箱账户设置了开启POP3/SMTP服务 
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=# 邮箱
MAIL_FROM_NAME=# 发送名

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=# redis 密码
REDIS_PORT=6379

GITEE_CLIENT_ID=# App ID
GITEE_CLIENT_SECRET=# App Key
GITEE_REDIRECT_URI=# App 回调地址

GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GITHUB_REDIRECT_URI=

QQ_CLIENT_ID=
QQ_CLIENT_SECRET=
QQ_REDIRECT_URI=

UPYUN_PROJECT_NAME =# 又拍云储存名称
UPYUN_OPERATOR_NAME =# 又拍云账号
UPYUN_OPERATOR_PASSWORD =# 又拍云密码
UPYUN_CNAME =# 又拍云域名

JWT_SECRET=# jwt key
```