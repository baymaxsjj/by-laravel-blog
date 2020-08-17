<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Home extends Model
{
    use SoftDeletes;
    //
    // 接受的字段
    protected $fillable = [
        'title', 'link', 'info','img_url','deleted_at'
    ];
    protected $table= 'homes';
    // 表格隐藏的字段
    protected $dates = ['deleted_at'];
    // 表格隐藏的字段
    // protected $hidden = [
    //     ''
    // ];

}
