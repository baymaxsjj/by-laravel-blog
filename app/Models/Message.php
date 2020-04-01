<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    //
    // 接受的字段
    protected $fillable = [
        'message', 'user_id','article'
    ];
    protected $table= 'messages';
    // 表格隐藏的字段
    // protected $hidden = [
    //     ''
    // ];

}
