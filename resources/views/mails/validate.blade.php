@component('mail::message')

<h2>亲爱的用户：{{ $data->name }}</h2>

重置密码的验证码是<span style="background:#b4ffeb;padding: 0 5px;color: #f56c6c;font-weight: bold;">{{ $data->captcha }} </span>，请在5分钟内验证。

@component('mail::button', ['url' => ''])
去验证
@endcomponent


@component('mail::panel')
如果不是本人操作发送的邮件，请提防账号被盗！
@endcomponent

<p style="text-align: right;padding-right: 10px;">
    Thanks<br>
    <span  style="color:#51cacc;font-weight: bold;">{{ config('app.name') }}</span>
</p>

@endcomponent
