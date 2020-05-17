<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Message extends Model
{
    use SoftDeletes;
    // 接受的字段
    protected $fillable = [
        'message', 'user_id','article'
    ];
    protected $table= 'messages';
    protected $dates = ['deleted_at'];
	// 反向关联
    public function user(){
      return $this->belongsTo('App\Models\User','user_id','id');
    }
	// 正向关联
    public function reply(){
      return $this->hasMany('App\Models\Reply','mess_id','id');
    }

}
