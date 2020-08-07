<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Link extends Model
{
    use SoftDeletes;
    //
    // 接受的字段
    protected $fillable = [
        'name', 'link', 'info','imgUrl','type','deleted_at'
    ];
    protected $table= 'links';
    // 表格隐藏的字段
    protected $dates = ['deleted_at'];
    // 表格隐藏的字段
    // protected $hidden = [
    //     ''
    // ];

}
