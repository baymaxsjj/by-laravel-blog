<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Model
{
    use SoftDeletes;
    // 接受的字段
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'avatar_url'
    ];
    protected $table= 'users';
    // 表格隐藏的字段
    protected $hidden = [
        'password', 'remember_token'
    ];
     protected $dates = ['deleted_at'];
    //将密码进行加密
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
