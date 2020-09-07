<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserAuth extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }
    // 接受的字段
    protected $fillable = [
        'user_id', 'login_type', 'login_name', 'password'
    ];
    protected $table= 'user_auths';
    // 表格隐藏的字段
    protected $hidden = [
        'password'
    ];
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    //将密码进行加密
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    // protected $appends = ['deleted_at'];
    // public function getDeletedAtAttribute($vlaue){
    //     return 1;
    // }
}