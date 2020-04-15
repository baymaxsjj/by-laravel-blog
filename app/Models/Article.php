<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;
     // 接受的字段
    protected $fillable = [
        'title', 'desc','content','img','classty','name','deleted_at','click','like','deleted_at'
    ];
    protected $table= 'articles';
    // 表格隐藏的字段
    protected $dates = ['deleted_at'];
}
