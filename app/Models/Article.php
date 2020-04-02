<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
     // 接受的字段
    protected $fillable = [
        'title', 'desc','content','img','classty','name','labe_id','clicl','like','deleted_at'
    ];
    protected $table= 'articles';
    // 表格隐藏的字段
}
