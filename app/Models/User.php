<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   // 接受的字段
   protected $fillable = [
    'name', 'phone', 'email', 'password', 'avatar_url'
];

// 表格隐藏的字段
protected $hidden = [
    'password', 'remember_token', 'is_admin'
];

//将密码进行加密
public function setPasswordAttribute($value)
{
    $this->attributes['password'] = bcrypt($value);
}
}
