@component('mail::message')

<h2>亲爱的用户：{{ $data->name }}</h2>

感谢你加入{{ config('app.name') }}!<br/>
因此我们可以给你发送重要的信息和更新，确认该邮箱地址无误<br/>
@component('mail::button', ['url' => 'https://www.yunmobai.cn/login'])
去登录
@endcomponent

<hr/>
<p class="cont">
    注意：该邮箱已被注册，如非本人操作，请及时登录并修改密码以保证帐户安全
</p>
<hr/>
<p class="cont" >
    此为系统邮件，请勿回复<br/>
    请保管好您的邮箱，避免账号被他人盗用
</p>

<h2>{{ config('app.name') }}</h2>

@endcomponent
