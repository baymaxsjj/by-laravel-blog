<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //
    // 接受的字段
    protected $fillable = [
        'name', 'link', 'info','imgUrl','apply'
    ];
    protected $table= 'links';
    // 表格隐藏的字段
    // protected $hidden = [
    //     ''
    // ];

}
