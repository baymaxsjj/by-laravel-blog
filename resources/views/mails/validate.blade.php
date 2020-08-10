@component('mail::message')

<h2>亲爱的用户：{{ $data->name }}</h2>

您正在修改密码，请在验证码输入框中输入：<span class="vali">{{ $data->captcha }} </span>,以完成操作。请在5分钟内验证。

@component('mail::button', ['url' => ''])
去验证
@endcomponent

<hr/>
<p class="cont">
    注意：此操作可能会修改您的密码、登录邮箱或绑定手机。如非本人操作，请及时登录并修改密码以保证帐户安全
    （工作人员不会向你索取此验证码，请勿泄漏！)
</p>
<hr/>
<p class="cont" >
    此为系统邮件，请勿回复<br/>
    请保管好您的邮箱，避免账号被他人盗用
</p>

<h2>{{ config('app.name') }}</h2>

@endcomponent
