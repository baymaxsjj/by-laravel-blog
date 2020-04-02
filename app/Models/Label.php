<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    //
    //
    // 接受的字段
    protected $fillable = [
        'label', 'user_id'
    ];
    protected $table= 'labels';
    // 表格隐藏的字段
    // protected $hidden = [
    //     ''
    // ];

}
