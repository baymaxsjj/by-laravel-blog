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
    // 表格隐藏的字段
    // protected $hidden = [
    //     ''
    // ];

}
